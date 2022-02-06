<?php

namespace App\Command;

use Aplab\Pst\Lib\MysqliManager\MysqliManager;
use Aplab\Pst\Lib\MysqliManager\Result;
use App\Component\FileStorage\LocalStorage;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

class SiteImportCommentCommand extends Command
{
    protected static $defaultName = 'site:import-comment';

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

    /**
     * SiteImportNewsCommand constructor.
     * @param MysqliManager $mysqli_manager
     * @param EntityManagerInterface $entity_manager
     * @param KernelInterface $kernel
     * @param LocalStorage $local_storage
     * @param string|null $name
     */
    public function __construct(
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
                    id, active, created, id_created_by, last_modified, id_modified_by, `delete`, name, title, 
                    additional, comment, html_title, meta_description, meta_keywords, sort_order, response_to_item_id, 
                    linked_object_class, linked_object_id, publication_datetime, publication_year, 
                    publication_date, publication_time, email, ip_address, user_agent, user_id
                FROM `u6291_ot`.`cs_linear_comment`
                ORDER BY `id`';
        return $conn->query($sql);
    }

    /**
     * @param void
     */
    private function clearAll(): void
    {
        $mysqli = $this->mysqliManager->getConnection();
        $sql = 'SET FOREIGN_KEY_CHECKS = 0';
        $mysqli->query($sql);
        $sql = 'TRUNCATE `v3.oytoy.ru`.`comment`';
        $mysqli->query($sql);
        $sql = 'SET FOREIGN_KEY_CHECKS = 1';
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
        $conn = $this->mysqliManager->getConnection();
        $em = $this->entityManager;
        $data_item = $data->fetch_object();

        while ($data_item) {

            switch ($data_item->linked_object_class) {
                case 'CSDatedInformationUnitOt' :
                    $sql = 'SELECT COUNT(*) FROM `v3.oytoy.ru`.`news` WHERE id = ' . $conn->e($data_item->linked_object_id);
                    if ($conn->query($sql)->fetch_one()) {
                        $data_item->linked_object_class = 'news';
                    } else {
                        $sql = 'SELECT COUNT(*) FROM `v3.oytoy.ru`.`picture` WHERE id = ' . $conn->e($data_item->linked_object_id);
                        $data_item->linked_object_class = 'picture';
                    }
                    break;

                case 'CSToyshopItem' :
                    $data_item->linked_object_class = 'product';
                    break;

                case 'CSTreeInformationUnit' :
                    $data_item->linked_object_class = 'interesting';
                    break;
            }

            $io->writeln(sprintf('<info>import comment id %s</info>', $data_item->id));
            $sql = 'INSERT INTO `v3.oytoy.ru`.`comment`
                    (id,
                     name,
                     publication_datetime,
                     comment,
                     active,
                     created_at,
                     last_modified,
                     user_agent,
                     ip_address,
                     email,
                     object_type,
                     object_id,
                     user_id,
                     parent_id)
                    VALUES(
                        ' . $conn->q($data_item->id) . ',
                        ' . $conn->q($data_item->name) . ',
                        ' . $conn->q($data_item->publication_datetime) . ',
                        ' . $conn->q($data_item->comment) . ',
                        ' . $conn->q($data_item->active) . ', 
                        ' . $conn->q($data_item->created) . ',
                        ' . $conn->q($data_item->last_modified) . ', 
                        ' . $conn->q($data_item->user_agent) . ',
                        ' . $conn->q($data_item->ip_address) . ',
                        ' . $conn->q($data_item->email) . ',
                        ' . $conn->q($data_item->linked_object_class) . ',
                        ' . $conn->q($data_item->linked_object_id) . ',
                        ' . $conn->q(intval($data_item->user_id)) . ',
                        ' . $conn->q($data_item->response_to_item_id) . '
                    )';

            dump($sql);

            $conn->query($sql);

            $data_item = $data->fetch_object();
        }
        $em->flush();
    }




}
