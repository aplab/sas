<?php

namespace App\Command;

use Aplab\Pst\Lib\MysqliManager\MysqliManager;
use Aplab\Pst\Lib\MysqliManager\Result;
use App\Component\FileStorage\LocalStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

class SiteImportCitiesCommand extends Command
{
    const SRC_CONNECTION = 'archiveural';

    protected static $defaultName = 'site:import-cities';
    protected static $defaultDescription = 'Add a short description for your command';
    protected MysqliManager $mysqliManager;
    protected EntityManagerInterface $entityManager;
    protected KernelInterface $kernel;
    protected LocalStorage $localStorage;
    protected SymfonyStyle $io;

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
    }

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
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
        $mysqli = $this->mysqliManager->getConnection();
        $sql = <<<'SQL'
            SET FOREIGN_KEY_CHECKS = 0
        SQL;
        $mysqli->query($sql);
        $sql = <<<'SQL'
            TRUNCATE `ritualarchive`.`city`
        SQL;
        $mysqli->query($sql);
        $sql = <<<'SQL'
            SET FOREIGN_KEY_CHECKS = 1
        SQL;
        $mysqli->query($sql);
    }

    protected function loadData(): Result
    {
        $conn = $this->mysqliManager->getConnection(self::SRC_CONNECTION);
        $sql = <<<'SQL'
            SELECT `id`,
                   `region_id`,
                   `name_ru`,
                   `name_en`,
                   `lat`,
                   `lon`,
                   `okato`,
                   `default`,
                   `active`
            FROM `cities`
        SQL;
        return $conn->query($sql);
    }

    /**
     * @throws Throwable
     */
    private function saveData(Result $data, SymfonyStyle $io)
    {
        $conn = $this->mysqliManager->getConnection();
        $progress = new ProgressBar($io, $data->num_rows);
        $progress->setRedrawFrequency(.01);
        $progress->setOverwrite(true);
        $progress->start();
        $data_item = $data->fetch_object();
        $conn->begin_transaction();
        try {
            while ($data_item) {
                $progress->advance();
                $sql = <<<'SQL'
                    INSERT INTO `ritualarchive`.`city` (`id`, `name`, `name_en`, `latitude`, `longitude`, `active`, `is_default`, `okato`)
                    VALUES (%d, %s, %s, %s, %s, %d, %d, %s);
                SQL;
                $sql = sprintf(
                    $sql,
                    $conn->e($data_item->id),
                    $conn->q($data_item->name_ru),
                    $conn->q($data_item->name_en),
                    $conn->q($data_item->lat),
                    $conn->q($data_item->lon),
                    $conn->e($data_item->active),
                    $conn->e($data_item->default),
                    $conn->q($data_item->okato),
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
