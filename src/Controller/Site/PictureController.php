<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site;


use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Component\Toolbar\Exception;
use App\Component\Uploader\ImageUploader;
use App\Dto\Model\VkPost\VkPost;
use App\Entity\Site\Picture;
use App\Tools\UrlToLink;
use DateTime;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class PictureController
 * @package App\Controller\Site
 */
#[Route(path: '/picture', name: 'picture_')]
class PictureController extends VkImportPlugin
{
    /**
     * @var string
     */
    protected $entityClassName = Picture::class;
    /**
     * @param DataTableRepresentation $data_table_representation
     * @return Response
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws Exception
     */
    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function listItems(DataTableRepresentation $data_table_representation)
    {
        $helper  = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl(
            'New item',
            $helper->getModulePath('add'),
            'fas fa-plus text-success');
        $toolbar->addHandler(
            'Delete selected',
            'AplDataTable.getInstance().del();',
            'fas fa-times text-danger'
        );
        $toolbar->addHandler(
            'Clone selected',
            'AplDataTable.getInstance().duplicate();',
            'far fa-clone text-warning'
        );
        $toolbar->addHandler(
            'Import from VK',
            sprintf('AplDataTable.getInstance().importFromVk(\'%s\');', $this->getVkImportUrl()),
            'fab fa-vk text-info');
        $data_table = $data_table_representation->getDataTable($this->getEntityClassName());
        $pager      = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }
    /**
     * @param $vk_post_data
     * @param ImageUploader $uploader
     * @return Picture
     * @throws \Exception
     */
    protected function tryCreateNewItemFromVkPostData($vk_post_data, ImageUploader $uploader)
    {
        $post_data = reset($vk_post_data);
        $vk_post   = new VkPost($post_data);
        foreach ($vk_post->getPhotos() as $photo) {
            try {
                $photo->getMaxSize()->download($uploader);
            } catch (Throwable $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }
        $newItem = new Picture();
        $text = trim($vk_post->getText());
        $name = $text;
        if (preg_match('/^([^#]+)#/', $text, $matches)) {
            $name = trim($matches[1]);
        }
        if (!$name) {
            $name = $text;
        }
        $post_created = $vk_post->getDate();
        if ($post_created) {
            $name = date('d.m.Y', $post_created);
        }
        $newItem->setName(mb_substr($name, 0, 255));
        $newItem->setText1($text);
        $text2                 = $text;
        $url_to_link_converter = new UrlToLink;
        foreach ($vk_post->getPhotos() as $photo) {
            if ($photo->getMaxSize()->isDownloaded()) {
                $url = $photo->getMaxSize()->getDownloadedUrl();
                if (!$newItem->getImage1()) {
                    $newItem->setImage1($url);
                    $newItem->setImage2('');// stub
                }
                break;
            }
        }
        $newItem->setText2($text2);
        if ($post_created) {
            $newItem->setPublicationDatetime((new DateTime())->setTimestamp($post_created));
        } else {
            $newItem->setPublicationDatetime(new DateTime());
        }
        $newItem->setActive(false);
        $newItem->setHtmlTitle('');
        $newItem->setMetaDescription('');
        $newItem->setMetaKeywords('');
        return $newItem;
    }
}
