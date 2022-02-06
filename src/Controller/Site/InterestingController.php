<?php declare(strict_types=1);
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
use App\Entity\Site\Interesting;
use App\Tools\UrlToLink;
use DateTime;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class NewsController
 * @package App\Controller\Site
 */
#[Route(path: '/interesting', name: 'interesting_')]
class InterestingController extends VkImportPlugin
{
    /**
     * @var string
     */
    protected string $entityClassName = Interesting::class;
    /**
     * @param DataTableRepresentation $data_table_representation
     * @return Response
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws ReflectionException
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
     * @return Interesting
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
        $newItem = new Interesting;
        $text = trim($vk_post->getText());
        $name = $text;
        if (preg_match('/^([^#]+)#/', $text, $matches)) {
            $name = trim($matches[1]);
        }
        if (!$name) {
            $name = $text;
        }
        $newItem->setName(mb_substr($name, 0, 255));
        $newItem->setText1($text);
        $text2                 = $text;
        $url_to_link_converter = new UrlToLink;
        foreach ($vk_post->getPhotos() as $photo) {
            if ($photo->getMaxSize()->isDownloaded()) {
                $url = $photo->getMaxSize()->getDownloadedUrl();
                $newItem->setImage1($url);
                $newItem->setImage2($url);
                /** @noinspection HtmlUnknownTarget */
                $text2      .= sprintf('<p><img src="%s" alt="">', $url);
                $photo_text = $photo->getText();
                if ($photo_text) {
                    $photo_text = $url_to_link_converter($photo_text);
                    $text2      .= sprintf('<br><small class="text-secondary">%s</small><br><br>', $photo_text);
                }
                $text2 .= '</p>';
            }
        }
        $newItem->setText2($text2);
        $newItem->setPublicationDatetime(new DateTime());
        $newItem->setActive(false);
        $newItem->setHtmlTitle('');
        $newItem->setMetaDescription('');
        $newItem->setMetaKeywords('');
        return $newItem;
    }
}
