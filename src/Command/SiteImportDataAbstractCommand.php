<?php

namespace App\Command;

use Aplab\Pst\Lib\MysqliManager\Connection;
use Aplab\Pst\Lib\MysqliManager\MysqliManager;
use App\Dto\SiteImportDataCommand\DataItem;
use App\Entity\Site\Cemetery\Cemetery;
use App\Entity\Site\City;
use App\Ftp\FileMetadata;
use App\Ftp\FtpManager;
use App\Repository\Site\Cemetery\CemeteryRepository;
use App\Repository\Site\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

#[AsCommand(
    name: 'site:import-data-abstract',
    description: 'Add a short description for your command',
)]
abstract class SiteImportDataAbstractCommand extends Command
{
    const CONNECTION_NAME = 'ekb';
    const CITY_NAME = 'Екатеринбург';
    const TRANSACTION_CHUNK_SIZE = 20000;

    protected MysqliManager $mysqliManager;
    protected FtpManager $ftpManager;
    protected EntityManagerInterface $entityManager;
    protected KernelInterface $kernel;
    protected SymfonyStyle $io;
    protected Connection $connection;
    protected CityRepository $cityRepository;
    protected City $city;
    protected CemeteryRepository $cemeteryRepository;
    protected array $cemeteries;
    protected array $cemeteriesByName;

    public function __construct(MysqliManager $m, FtpManager $f, EntityManagerInterface $e, KernelInterface $k, CityRepository $r, CemeteryRepository $c, ?string $name = null)
    {
        parent::__construct($name);
        $this->mysqliManager = $m;
        $this->ftpManager = $f;
        $this->entityManager = $e;
        $this->kernel = $k;
        $this->connection = $this->mysqliManager->getConnection();
        $this->cityRepository = $r;
        $this->cemeteryRepository = $c;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->io = $io;
        $city = $this->cityRepository->findOneByName(static::CITY_NAME);
        if (!($city instanceof City)) {
            throw new InvalidArgumentException(sprintf('city not found: %s', static::CITY_NAME));
        }
        $this->city = $city;
        $cemeteries = $this->cemeteryRepository->findByCity($this->city);
        foreach ($cemeteries as $cemetery) {
            $this->cemeteries[$cemetery->getId()] = $cemetery;
            $this->cemeteriesByName[trim(mb_strtolower($cemetery->getName()))] = $cemetery;
        }
        $ftp = $this->ftpManager->getConnection(static::CONNECTION_NAME);
        $files = ($ftp->getTargetFilesOrdered());
        foreach ($files as $file) {
            $this->handleFile($io, $ftp, $file);
        }
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return Command::SUCCESS;
    }

    protected function handleFile(SymfonyStyle $io, \App\Ftp\Connection $c, FileMetadata $f)
    {
        $collector = [];
        $io->info(sprintf('processing file %s', $f->getPath()));
        $tmp_handle = $c->loadData($f);
        $possible_keys = [# FIELDS ORDER IS STRICTLY IMPORTANT
            'id',
            'name',
            'birthDate',
            'birthYear',
            'deathDate',
            'deathYear',
            'age',
            'burialTypeName',
            'sectionName',
            'alleyName',
            'cemeteryName',
            'latitude',
            'longitude',
            'firstPhotoPath',
            'secondPhotoPath',
        ];
        $possible_data_length = sizeof($possible_keys);
        $counter = 0;
        while (($buffer = fgets($tmp_handle, 4096)) !== false) {
            printf("processing buffer %s                 \r", number_format($counter++));
            if (strlen($buffer) < 10) {
                $io->warning(sprintf('skip too short buffer %s', $buffer));
                continue;
            }
            $data = str_getcsv($buffer, ';', '');
            $data_length = sizeof($data);
            if ($data_length > $possible_data_length) {
                $data = array_slice($data, 0, $possible_data_length);
                $data_length = sizeof($data);
            }
            if ($data_length !== $possible_data_length) {
                $io->warning(sprintf('skip wrong data size %d, buffer: %s', $data_length, $buffer));
                continue;
            }
            $src = array_combine($possible_keys, $data);
            array_walk($src, function (&$v, $k) {
                $v = trim($v);
                $v = preg_replace('/\s+/', ' ', $v);
            });
            try {
                $o = DataItem::createFromArray($src);
                $collector[] = $o;
            } catch (Throwable $exception) {
                $io->warning(sprintf('unable to create item from array, cause: %s', $exception->getMessage()));
                dump($src);
                continue;
            }
        }
        if (!feof($tmp_handle)) {
            throw new RuntimeException(sprintf('fgets error, file: %s', $f->getPath()));
        }
        fclose($tmp_handle);
        $this->store($collector, $io);
    }

    /**
     * @param DataItem[]
     * @param SymfonyStyle $io
     * @throws Throwable
     * @noinspection DuplicatedCode
     */
    protected function store(array $data, SymfonyStyle $io)
    {
        $progress = new ProgressBar($io, sizeof($data));
        $progress->setBarCharacter('▓');
        $progress->setEmptyBarCharacter('░');
        $progress->setProgressCharacter('▒');
        $progress->setBarWidth(100);
        $progress->setRedrawFrequency(.01);
        $progress->setOverwrite(true);
        $progress->start();
        $conn = $this->connection;
        try {
            $sql = <<<'SQL'
                    INSERT INTO `ritualarchive`.`burial` 
                    (
                        `id`, 
                        `first_name`, `middle_name`, `last_name`, `full_name`, 
                        `birth_date`, `birth_year`, `death_date`, `death_year`, `age`, 
                        `city_id`, `cemetery_id`,
                        `latitude`, `longitude`, 
                        `burial_type_name`, `section_name`, `alley_name`, `cemetery_name`, 
                        `photo_path1`, `photo_path2`, `created_at`, `last_modified`, `obituary`
                    ) VALUES %s 
                    ON DUPLICATE KEY UPDATE 
                        `first_name` = VALUES(`first_name`),
                        `middle_name` = VALUES(`middle_name`),
                        `last_name` = VALUES(`last_name`),
                        `full_name` = VALUES(`full_name`),
                        `birth_date` = VALUES(`birth_date`),
                        `birth_year` = VALUES(`birth_year`),
                        `death_date` = VALUES(`death_date`),
                        `death_year` = VALUES(`death_year`),
                        `age` = VALUES(`age`),
                        `city_id` = VALUES(`city_id`),
                        `cemetery_id` = VALUES(`cemetery_id`),
                        `latitude` = VALUES(`latitude`),
                        `longitude` = VALUES(`longitude`),
                        `burial_type_name` = VALUES(`burial_type_name`),
                        `section_name` = VALUES(`section_name`),
                        `alley_name` = VALUES(`alley_name`),
                        `cemetery_name` = VALUES(`cemetery_name`),
                        `photo_path1` = VALUES(`photo_path1`),
                        `photo_path2` = VALUES(`photo_path2`),
                        `last_modified` = DEFAULT,
                        `obituary` = ''
            SQL;
            $values = [];
            /** @var DataItem $data_item */
            foreach ($data as $data_item) {
                $progress->advance();
                $val = '(%d, %s, %s, %s, %s, %s, %d, %s, %d, %d,
                        %d, %d, %s, %s, %s, %s, %s, %s,
                        %s, %s, DEFAULT, DEFAULT, \'\')
                        ';
                $name = $data_item->getName();
                $parts = $this->getNameParts($name);
                $cemetery_name = $data_item->getCemeteryName();
                $cemetery = $this->getCemeteryByName($cemetery_name);
                $cemetery_id = ($cemetery instanceof Cemetery) ? $cemetery->getId() : null;
                $val = sprintf(
                    $val,
                    $conn->e($data_item->getId()),

                    $conn->q($parts['first']),
                    $conn->q($parts['middle']),
                    $conn->q($parts['last']),
                    $conn->q($name),

                    $data_item->getBirthDateMysql() ? $conn->q($data_item->getBirthDateMysql()) : "null",
                    $conn->e($data_item->getBirthYear()),

                    $data_item->getDeathDateMysql() ? $conn->q($data_item->getDeathDateMysql()) : "null",
                    $conn->e($data_item->getDeathYear()),

                    $conn->e($data_item->getAge()),
                    $conn->e($this->city->getId()),
                    $cemetery_id ? $conn->e($cemetery_id) : "null",

                    $conn->q($data_item->getLatitude()),
                    $conn->q($data_item->getLongitude()),

                    $conn->q($data_item->getBurialTypeName()),
                    $conn->q($data_item->getSectionName()),
                    $conn->q($data_item->getAlleyName()),
                    $conn->q($data_item->getCemeteryName()),

                    $conn->q($data_item->getFirstPhotoPath()),
                    $conn->q($data_item->getSecondPhotoPath()),
                );
                $values[] = $val;
                if (sizeof($values) >= static::TRANSACTION_CHUNK_SIZE) {
                    $conn->query(sprintf($sql, join(',', $values)));
                    $values = [];
                }
            }
            if (sizeof($values)) {
                $query = sprintf($sql, join(',', $values));
                $conn->query($query);
            }
        } catch (Throwable $exception) {
            //$conn->rollback();
            /** @noinspection PhpUndefinedVariableInspection */
            dump($sql);
            throw $exception;
        }
        //$conn->commit();
        $progress->finish();
    }

    protected function getNameParts(string $full_name)
    {
        if (!$full_name) {
            $full_name = '';
        }
        $parts = preg_split("/[\s]+/", $full_name, -1, PREG_SPLIT_NO_EMPTY);
        return [
            'last' => $parts[0] ?? '',
            'first' => $parts[1] ?? '',
            'middle' => $parts[2] ?? '',
        ];
    }

    protected function getCemeteryByName(string $name): ?Cemetery
    {
        return $this->cemeteriesByName[trim(mb_strtolower($name))] ?? null;
    }
}
