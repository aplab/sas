<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 04.09.2018
 * Time: 14:25
 */

namespace App\Controller;


use App\Component\FileStorage\LocalStorage;
use App\Component\Uploader\FileUploader;
use App\Component\Uploader\ImageUploader;
use App\Entity\HistoryUploadImage;
use Exception;
use Respect\Validation\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class FileController
 * @package App\Controller
 */
#[Route(path: '/xhr', name: 'xhr_')]
class XhrController extends AbstractController
{
    /**
     * @param LocalStorage $localStorage
     * @return JsonResponse
     */
    #[Route(path: '/uploadImage/', name: 'upload_image', methods: ['POST'])]
    public function uploadImage(LocalStorage $localStorage)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $uploader = new ImageUploader($localStorage, $entity_manager);
        try {
            $url = $uploader->receive();
            return new JsonResponse([
                'status' => 'ok',
                'url' => $url
            ]);
        } catch (Throwable $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ]);
        }
    }
    /**
     * @param LocalStorage $localStorage
     * @return JsonResponse
     */
    #[Route(path: '/uploadFile/', name: 'upload_file', methods: ['POST'])]
    public function uploadFile(LocalStorage $localStorage)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $uploader = new FileUploader($localStorage, $entity_manager);
        try {
            $url = $uploader->receive();
            return new JsonResponse([
                'status' => 'ok',
                'url' => $url
            ]);
        } catch (Throwable $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ]);
        }
    }
    /**
     * @param int $offset
     * @return JsonResponse
     */
    #[Route(path: '/historyUploadImage/listItems/{offset}/', name: 'history_upload_image_list_items', requirements: ['offset' => '^\d+$'], methods: ['GET'])]
    public function historyUploadImageListItems($offset)
    {
        $items = $this->getDoctrine()->getRepository(HistoryUploadImage::class)->findBy(
            [],
            ['favorites' => 'DESC', 'id' => 'desc'],
            103, $offset
        );
        return new JsonResponse($items);
    }
    /**
     * @param int $offset
     * @return JsonResponse
     */
    #[Route(path: '/historyUploadImage/listFavorites/{offset}/', name: 'history_upload_image_list_favorites', requirements: ['offset' => '^\d+$'], methods: ['GET'])]
    public function historyUploadImageListFavorites($offset)
    {
        $items = $this->getDoctrine()->getRepository(HistoryUploadImage::class)->findBy(
            ['favorites' => 1],
            ['favorites' => 'DESC', 'id' => 'desc'],
            103, $offset
        );
        return new JsonResponse($items);
    }
    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route(path: '/historyUploadImage/favItem/{id}/', name: 'history_upload_image_fav_item', requirements: ['id' => '^\d+$'], methods: ['POST'])]
    public function favoriteImage($id)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $repository = $entity_manager->getRepository(HistoryUploadImage::class);
        $item = $repository->find($id);
        if (!($item instanceof HistoryUploadImage)) {
            return new JsonResponse([]);
        }
        if ($item->getFavorites()) {
            $item->setFavorites(false);
        } else {
            $item->setFavorites(true);
        }
        $entity_manager->persist($item);
        $entity_manager->flush();
        return new JsonResponse([
            'status' => 'ok',
            'value' => $item->getFavorites()
        ]);
    }
    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route(path: '/historyUploadImage/dropItem/{id}/', name: 'history_upload_image_drop_item', requirements: ['id' => '^\d+$'], methods: ['POST'])]
    public function dropImage($id)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $repository = $entity_manager->getRepository(HistoryUploadImage::class);
        $item = $repository->find($id);
        if (!($item instanceof HistoryUploadImage)) {
            return new JsonResponse([]);
        }
        $entity_manager->remove($item);
        $entity_manager->flush();
        return new JsonResponse([
            'status' => 'ok'
        ]);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route(path: '/aplDataTable/editProperty/', name: 'apl_data_table_edit_property', methods: ['POST'])]
    public function editProperty(Request $request)
    {
        try {
            $post = $request->request;
            $class = $post->get('class');
            if (!class_exists($class)) {
                throw new Exception('Unknown entity type');
            }
            $pk = $post->get('pk');
            $id = $pk['id'];
            Validator::digit()->check($id);
            $name = $post->get('name');
            $value = $post->get('value');
            $entity_manager = $this->getDoctrine()->getManager();
            $repository = $entity_manager->getRepository($class);
            $item = $repository->find($id);
            if (!($item instanceof $class)) {
                throw new Exception('Object not found');
            }
            $setter = 'set' . ucfirst($name);
            $item->$setter($value);
            $entity_manager->persist($item);
            $entity_manager->flush();
        } catch (Throwable $exception) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
        return new JsonResponse([
            'status' => 'ok'
        ]);
    }
    /**
     * @param LocalStorage $localStorage
     * @return JsonResponse
     */
    #[Route(path: '/galleryBuilder/', name: 'gallery_builder', methods: ['POST'])]
    public function galleryBuilder(LocalStorage $localStorage)
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $uploader = new ImageUploader($localStorage, $entity_manager);
        $uploader->withGalleryBuilder = true;
        try {
            $url = $uploader->receive();
            return new JsonResponse([
                'status' => 'ok',
                'url' => $url
            ]);
        } catch (Throwable $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ]);
        }
    }
}
