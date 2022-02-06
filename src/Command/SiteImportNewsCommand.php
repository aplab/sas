<?php

namespace App\Command;

use Aplab\Pst\Lib\MysqliManager\MysqliManager;
use Aplab\Pst\Lib\MysqliManager\Result;
use App\Component\FileStorage\LocalStorage;
use App\Component\Uploader\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

class SiteImportNewsCommand extends Command
{
    protected static $defaultName = 'site:import-news';

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
                    `id`,
                    `name`,
                    `active`,
                    `created`,
                    `id_created_by`,
                    `last_modified`,
                    `id_modified_by`,
                    `delete`,
                    `title`,
                    `additional`,
                    `comment`,
                    `html_title`,
                    `meta_description`,
                    `meta_keywords`,
                    `sort_order`,
                    `container_id`,
                    `text1`,
                    `text2`,
                    `image1_id`,
                    `image1_format_id`,
                    `image2_id`,
                    `image2_format_id`,
                    `publication_datetime`,
                    `publication_year`,
                    `publication_date`,
                    `publication_time`,
                    `important`,
                    `master`
                FROM `u6291_ot`.`cs_dated_information_unit_ot`
                WHERE `container_id` = 1  -- and id=300
                ORDER BY `id`';
        return $conn->query($sql);
    }

    /**
     * @param void
     */
    private function clearAll(): void
    {
        $mysqli = $this->mysqliManager->getConnection();
        $sql = 'TRUNCATE `v3.oytoy.ru`.`news`';
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
            $io->writeln(sprintf('<info>import news id %s</info>', $data_item->id));

            $sql = 'INSERT INTO `v3.oytoy.ru`.news
                    (id, name, publication_datetime, image1, image2, text1, text2, active, 
                    created_at, last_modified, html_title, meta_description, meta_keywords)
                    VALUES(
                        ' . $conn->q($data_item->id) . ',
                        ' . $conn->q($data_item->name) . ',
                        ' . $conn->q($data_item->publication_datetime) . ', 
                        ' . $conn->q($this->getImageById($data_item->image1_id)) . ', 
                        ' . $conn->q($this->getImageById($data_item->image2_id)) . ', 
                        ' . $conn->q($this->handleInlineImages($data_item->text1)) . ', 
                        ' . $conn->q($this->handleInlineImages($data_item->text2)) . ', 
                        ' . $conn->q($data_item->active) . ', 
                        ' . $conn->q($data_item->created) . ',
                        ' . $conn->q($data_item->last_modified) . ', 
                        \'\', 
                        \'\', 
                        \'\'
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

    protected function handleInlineImages(string $text, &$images = [])
    {
        $text = preg_replace_callback('/<img.*?>/isu', function ($m) use (&$images) {
            $tag = $m[0];
            //$tag = preg_replace('/height="\\d+"/', 'height="auto"', $tag);
            $tag = preg_replace('/height="\\d+"/', '', $tag);
            $tag = preg_replace('/height="auto"/', '', $tag);
            $tag = preg_replace('/width="\\d+"/', '', $tag);
            $tag = preg_replace('/width="auto"/', '', $tag);
            $tag = preg_replace_callback('/src="(.*?)"/isu', function ($s) use (&$images) {
                $url = $s[1];
                if (!preg_match('#/capsule/imglib/data/\\d+/(\\d+)/#', $url, $ma)) {
                    return 'src="' . $url . '"';
                }
                $id = $ma[1];
                $result = $this->getImageById($id);
                if (!$result) {
                    $result = $url;
                }
                $this->io->writeln(sprintf('result: <comment>%s</comment>', $result));
                $images[] = $result;
                return 'src="' . $result . '"';
            }, $tag);
            return $tag;
        }, $text);
        /** @noinspection HtmlRequiredAltAttribute */
        $text = preg_replace('#<p>&nbsp;<img#isu', '<p><img', $text);
        $text = preg_replace('#http://www.oytoy.ru#isu', 'https://oytoy.ru', $text);
        $text = preg_replace(
            '#<a(.*?)href="/capsule/imglib/data/\\d+/\\d+/[^>]+?>(.*?)</a>#isu',
            '$2', $text);
        return $text;
    }
}
