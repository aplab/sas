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
    name: 'site:import-cemetery',
    description: 'Add a short description for your command',
)]
class SiteImportCemeteryCommand extends Command
{
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
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return 0;
    }

    private function clearAll(): void
    {
        $sql = <<<'SQL'
            SET FOREIGN_KEY_CHECKS = 0
        SQL;
        $this->connection->query($sql);
        $sql = <<<'SQL'
            TRUNCATE `ritualarchive`.`cemetery`
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
            SELECT `id`,
                   `name`,
                   `city_id`,
                   `address`,
                   `phone`,
                   `type`,
                   `description`,
                   `PolygonGPS`,
                   `enable`
            FROM `archiveural`.`cemetery`
        SQL;
        return $this->connection->query($sql);
    }

    /**
     * @throws Throwable
     */
    private function saveData(Result $data, SymfonyStyle $io)
    {
        $progress = new ProgressBar($io, $data->num_rows);
        $progress->setRedrawFrequency(.01);
        $progress->setOverwrite(true);
        $progress->start();
        $data_item = $data->fetch_object();
        $conn = $this->connection;
        $conn->begin_transaction();
        try {
            while ($data_item) {
                $progress->advance();
                $sql = <<<'SQL'
                    INSERT INTO `ritualarchive`.`cemetery` (`id`, `name`, `city_id`, `address`, `phone`, `active`, `description`)
                    VALUES (%d, %s, %d, %s, %s, %d, %s);
                SQL;
                $sql = sprintf(
                    $sql,
                    $conn->e($data_item->id),
                    $conn->q($data_item->name),
                    $conn->e($data_item->city_id),
                    $conn->q($data_item->address),
                    $conn->q($data_item->phone),
                    $conn->e($data_item->enable),
                    $conn->q($data_item->description),
                );
                $conn->query($sql);
                $data_item = $data->fetch_object();
            }
        } catch (Throwable $exception) {
            $conn->rollback();
            throw $exception;
        }
        $conn->commit();
        $progress->finish();
    }
}
