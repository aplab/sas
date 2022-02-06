<?php

namespace App\Command;

use Aplab\Pst\Lib\MysqliManager\MysqliManager;
use Aplab\Pst\Lib\MysqliManager\Result;
use App\Component\FileStorage\LocalStorage;
use App\Component\Uploader\ImageUploader;
use App\Entity\User;
use App\Service\PasswordGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Throwable;

class SiteImportUserCommand extends Command
{
    protected static $defaultName = 'site:import-user';

    /**
     * @var MysqliManager
     */
    protected $mysqliManager;

    /**
     * @var
     */
    protected $entityManager;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var LocalStorage
     */
    protected $localStorage;

    /**
     * @var SymfonyStyle
     */
    protected $io;

    protected $passwordEncoder;

    /**
     * SiteImportNewsCommand constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MysqliManager $mysqli_manager
     * @param EntityManagerInterface $entity_manager
     * @param KernelInterface $kernel
     * @param LocalStorage $local_storage
     * @param string|null $name
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        MysqliManager $mysqli_manager,
        EntityManagerInterface $entity_manager,
        KernelInterface $kernel,
        LocalStorage $local_storage,
        ?string $name = null
    )
    {
        parent::__construct($name);
        $this->mysqliManager = $mysqli_manager;
        $this->entityManager = $entity_manager;
        $this->kernel = $kernel;
        $this->localStorage = $local_storage;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->io = $io;

//        $text = '<p><a href="/capsule/imglib/data/539/8381/XthjaaI0PzA[1].jpg"><img alt="выставка кукол, выставка игрушек, авторские куклы, кукла ручная работа, много кукол и игрушек, ярмарка кукол"
//    src="/filestorage/89a/baa/d6c/89abaad6c940d2af339cf1f9c2afc283.jpg" /></a></p>';
//        if (preg_match(
        /*            '#<a(.*?)href="/capsule/imglib/data/\\d+/\\d+/[^>]+?>(.*?)</a>#isu', $text, $ma)) {*/
//            dump($ma);
//        }

        $this->clearAll();
        $data = $this->loadData();
        $this->saveData($data, $io);
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }

    protected function loadData()
    {
        $conn = $this->mysqliManager->getConnection();
        $sql = 'SELECT
                    `id`,
                    `active`,
                    `created`,
                    `id_created_by`,
                    `last_modified`,
                    `id_modified_by`,
                    `delete`,
                    `login`,
                    `password`,
                    `email`,
                    `temporary_password`,
                    `activation_key`,
                    `gender`,
                    `image_id`,
                    `signature`,
                    `birthdate`
                FROM `u6291_ot`.`cs_site_user_ot`
                ORDER BY `id`';
        return $conn->query($sql);
    }

    /**
     * @param void
     */
    private function clearAll(): void
    {
        $mysqli = $this->mysqliManager->getConnection();
        $sql = 'TRUNCATE `v3.oytoy.ru`.`user`';
        $mysqli->query($sql);
    }

    /**
     * @param Result $data
     *
     * @param SymfonyStyle $io
     * @throws Exception
     */
    private function saveData(Result $data, SymfonyStyle $io)
    {
        $user_stub = new User;
        $passgen = new PasswordGenerator();
        $conn = $this->mysqliManager->getConnection();
        $em = $this->entityManager;
        $data_item = $data->fetch_object();
        while ($data_item) {
            $pass = $passgen->generatePassword(PasswordGenerator::ALGORITHM_CVCVCDCVCVC);
            $enc_pass = $this->passwordEncoder->encodePassword($user_stub, $pass);
            dump($pass, $enc_pass);
            $io->writeln(sprintf('<info>import news id %s</info>', $data_item->id));

            if (!$data_item->birthdate) {
                $data_item->birthdate = 'null';
            } else {
                $data_item->birthdate = $conn->q($data_item->birthdate);
            }

            $sql = 'INSERT INTO `v3.oytoy.ru`.`user`
                    (
                        `id`,
                        `email`,
                        `roles`,
                        `password`,
                        `name`,
                        `birthdate`,
                        `created_at`,
                        `last_modified`,
                        `signature`,
                        `temporary_password`,
                        `deleted`,
                        `activation_key`,
                        `avatar`,
                        `active`
                    )
                    VALUES
                    (
                         ' . $conn->q($data_item->id) . ' -- id - BIGINT(20) NOT NULL
                        ,' . $conn->q($data_item->email) . ' -- email - VARCHAR(180) NOT NULL
                        ,\'[]\' -- roles - LONGTEXT NOT NULL
                        ,' . $conn->q($enc_pass) . ' -- name - VARCHAR(255) NOT NULL
                        ,' . $conn->q($data_item->login) . ' -- name - VARCHAR(255) NOT NULL
                        ,' . $data_item->birthdate . ' -- birthdate - DATETIME NOT NULL
                        ,' . $conn->q($data_item->created) . ' -- created_at - DATETIME
                        ,' . $conn->q($data_item->last_modified) . ' -- last_modified - DATETIME
                        ,' . $conn->q($data_item->signature) . ' -- signature - LONGTEXT NOT NULL
                        ,\'\' -- temporary_password - VARCHAR(255) NOT NULL
                        ,' . $conn->q($data_item->delete) . ' -- deleted - TINYINT(1) NOT NULL
                        ,' . $conn->q($data_item->activation_key) . ' -- activation_key - VARCHAR(255) NOT NULL
                        ,' . $conn->q($this->getImageById($data_item->image_id)) . ' -- avatar - VARCHAR(255) NOT NULL
                        ,' . $conn->q($data_item->active) . ' -- active - TINYINT(1) NOT NULL
                    )';

            dump($sql);

            $conn->query($sql);

            $data_item = $data->fetch_object();
        }
        $em->flush();
    }

    private function getImageById($id)
    {
        $result = '';
        $conn = $this->mysqliManager->getConnection();
        $image = $conn->query('
                SELECT * FROM `u6291_ot`.`cs_image_library_item`
                WHERE `id` = ' . $conn->q($id))->fetch_object();
        if ($image) {
//            $path = '/home/polyanin/DEVELOP/polyanin/project/oytoy-images/data/' .
            $path = '/home/polyanin/polyanin/project/mirror.old.oytoy.ru/oytoy.ru/www/capsule/imglib/data/' .
                $image->group_id . '/' . $image->id . '/' . $image->name . '.' . $image->type;
            try {
                $uploader = new ImageUploader($this->localStorage, $this->entityManager);
                $result = $uploader->receive($path);
                $this->io->writeln(sprintf('<comment>%s</comment>', $result));
            } catch (Throwable $exception) {
                $this->io->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
            }
        } else {
            $this->io->writeln(sprintf('<error>%s</error>', 'image not found'));
        }
        return $result;
    }
}
