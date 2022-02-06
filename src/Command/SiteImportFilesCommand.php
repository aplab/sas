<?php

namespace App\Command;

use Aplab\Pst\Lib\MysqliManager\Connection;
use Aplab\Pst\Lib\MysqliManager\MysqliManager;
use Aplab\Pst\Lib\MysqliManager\Result;
use App\Component\FileStorage\LocalStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

#[AsCommand(
    name: 'site:import-files',
    description: 'Add a short description for your command',
)]
class SiteImportFilesCommand extends Command
{
    const BULK_SIZE = 100000;

    protected MysqliManager $mysqliManager;
    protected EntityManagerInterface $entityManager;
    protected KernelInterface $kernel;
    protected LocalStorage $localStorage;
    protected SymfonyStyle $io;
    protected Connection $connection;

    public function __construct(
        MysqliManager          $mysqli_manager,
        EntityManagerInterface $entity_manager,
        KernelInterface        $kernel,
        LocalStorage           $local_storage,
        ?string                $name = null
    )
    {
        parent::__construct($name);
        $this->mysqliManager = $mysqli_manager;
        $this->entityManager = $entity_manager;
        $this->kernel = $kernel;
        $this->localStorage = $local_storage;
        $this->connection = $this->mysqliManager->getConnection();
    }

    /**
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->io = $io;
        $this->clearAll();
        $data = $this->loadData();
        $this->saveData($data, $io);
        $io->success('success, ' . memory_get_peak_usage(true));
        return 0;
    }

    private function clearAll(): void
    {
        $sql = <<<'SQL'
            SET FOREIGN_KEY_CHECKS = 0
        SQL;
        $this->connection->query($sql);
        $sql = <<<'SQL'
            TRUNCATE `ritualarchive`.`file`
        SQL;
        $this->connection->query($sql);
        $sql = <<<'SQL'
            SET FOREIGN_KEY_CHECKS = 1
        SQL;
        $this->connection->query($sql);
    }

    protected function loadData(): Result
    {
        $sql = <<<'SQL'
            SELECT `id`, `filename`, `type`, `module`, `parent`, `latitude`, `longitude`, `user_id`, `createphoto`
            FROM `archiveural`.`files`
        SQL;
        return $this->connection->query($sql);
    }

    /**
     * @throws Throwable
     */
    private function saveData(Result $data, SymfonyStyle $io)
    {
        $progress = new ProgressBar($io, $data->num_rows);
        $progress->setBarCharacter('░');
        $progress->setEmptyBarCharacter('▓');
//        $progress->setProgressCharacter('▒');
        $progress->setProgressCharacter('▓');
        $progress->setBarWidth(100);
        $progress->setRedrawFrequency(1);
        $progress->setOverwrite(true);
        $progress->start();
        $data_item = $data->fetch_object();
        $conn = $this->connection;
        $conn->autocommit(false);
        $conn->begin_transaction();
        $counter = 0;
        try {
            while ($data_item) {
                $progress->advance();
                $sql = <<<'SQL'
                    INSERT INTO `ritualarchive`.`file` (
                        `id`,       
                        `filename`, 
                        `module`,   
                        `type`,     
                        `latitude`, 
                        `longitude`,
                        `burial_id`,
                        `user_id`,  
                        `created`
                    )
                    VALUES (%d, %s, %s, %s, %s, %s, %d, %d, %s);
                SQL;
                $sql = sprintf(
                    $sql,
                    $conn->e($data_item->id),
                    $conn->q($data_item->filename ?? ''),
                    $conn->q($data_item->module ?? ''),
                    $conn->q($data_item->type ?? ''),
                    $conn->q($data_item->latitude ?? 0),
                    $conn->q($data_item->longitude ?? 0),
                    $conn->e($data_item->parent ?? 0),
                    $conn->q($data_item->user_id ?? 0),
                    $conn->q($data_item->createphoto),
                );
                $conn->query($sql);
                $data_item = $data->fetch_object();
                $counter++;
                if ($counter === static::BULK_SIZE) {
                    $counter = 0;
                    $conn->commit();
                    $conn->begin_transaction();
                }
            }
        } catch (Throwable $exception) {
            $conn->rollback();
            $this->clearAll();
            /** @noinspection PhpUndefinedVariableInspection */
            dump($sql);
            throw $exception;
        }
        $conn->commit();
        $progress->finish();
    }
}
