<?php


namespace App\Controller\Site;


use App\Component\FileStorage\LocalStorage;
use App\Component\Uploader\ImageUploader;
use App\Controller\ReferenceController;
use App\Entity\Site\News;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

abstract class VkImportPlugin extends ReferenceController
{
    protected static string $REQUEST_KEY = 'vkWallPostUrl';

    protected string $listUrl, $vkImportUrl, $vkCodeUrl;

    public function getListUrl(): string
    {
        if (!isset($this->listUrl)) {
            $this->listUrl = $this->generateUrl($this->getRouteAnnotation()->getName() . 'list');
        }
        return $this->listUrl;
    }

    public function getVkImportUrl(): string
    {
        if (!isset($this->vkImportUrl)) {
            $this->vkImportUrl = $this->generateUrl($this->getRouteAnnotation()->getName() . 'vkimport');
        }
        return $this->vkImportUrl;
    }

    public function getVkCodeUrl(): string
    {
        if (!isset($this->vkCodeUrl)) {
            $this->vkCodeUrl = $this->generateUrl(
                $this->getRouteAnnotation()->getName() . 'vkcode',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
        }
        return $this->vkCodeUrl;
    }

    /**
     * @noinspection PhpUnused
     */
    #[Route(path: '/vkimport', name: 'vkimport', methods: ['POST'])]
    public function importFromVk(): RedirectResponse
    {
        $helper    = $this->adminControllerHelper;
        $vkPostUrl = $_REQUEST[static::$REQUEST_KEY] ?? null;
        if (!$vkPostUrl) {
            return new RedirectResponse($this->getListUrl());
        }
        $helper->getSession()->set(static::$REQUEST_KEY, $vkPostUrl);
        return $this->vkAuth();
    }

    protected function vkAuth(): RedirectResponse
    {
        $oauth        = new VKOAuth();
        $client_id    = 7235592;//ID приложения
        $redirect_url = $this->getVkCodeUrl();
        $display      = VKOAuthDisplay::PAGE;
        $scope        = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
        $state        = 'secret_state_code';
        $browser_url  = $oauth->getAuthorizeUrl(
            VKOAuthResponseType::CODE,
            $client_id,
            $redirect_url,
            $display,
            $scope,
            $state);
        return new RedirectResponse($browser_url);
    }

    /**
     * @param LocalStorage $localStorage
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     * @throws Exception
     * @noinspection PhpUnused
     */
    #[Route(path: '/code', name: 'vkcode', methods: ['GET'])]
    public function vkCode(LocalStorage $localStorage, EntityManagerInterface $manager): RedirectResponse|Response
    {
        if (!isset($_GET['code'])) {
            $this->addFlash('error', 'cannot get code');
            return new RedirectResponse($this->getListUrl());
        }
        $code          = $_GET['code'];
        $oauth         = new VKOAuth();
        $client_id     = 7235592;
        //ID приложения
        $client_secret = 'KjTQkd5IxbJUmUz6h8WJ';
        $redirect_url  = $this->getVkCodeUrl();
        try {
            $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_url, $code);
        } catch (Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());
            return new RedirectResponse($this->getListUrl());
        }
        $access_token = $response['access_token'];
        $vk           = new VKApiClient();
        try {
            $post_source = $this->retrievePostSource();
            $response    = $vk->wall()->getById($access_token, array(
                'posts' => array($post_source->postId)
            ));
        } catch (Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());
            return new RedirectResponse($this->getListUrl());
        }
        $uploader = new ImageUploader($localStorage, $manager);
        try {
            $new_item = $this->tryCreateNewItemFromVkPostData($response, $uploader);
            $class    = $this->getEntityClassName();
            if ($new_item instanceof $class) {
                $new_item->setSource($post_source->source)->setSourceUrl($post_source->source);
                $manager->persist($new_item);
                $manager->flush();
                $id = $new_item->getId();
                return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'edit', ['id' => $id]);
            }
        } catch (Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());
            return new RedirectResponse($this->getListUrl());
        }
        return new RedirectResponse($this->getListUrl());
    }

    /**
     * @throws Exception
     */
    protected function retrievePostSource(): object
    {
        $session = $this->adminControllerHelper->getSession();
        if (!$session->has(static::$REQUEST_KEY)) {
            throw new Exception('unable to retrieve vk post id');
        }
        $source = trim($session->get(static::$REQUEST_KEY));
        if (preg_match(
            '/[\\d_\-]{3,}$/iu',
            $source,
            $matches)) {
            return new class($source, $matches[0]) {
                public string $source, $postId;

                public function __construct(string $source, string $post_id)
                {
                    $this->source = $source;
                    $this->postId = $post_id;
                }
            };
        }
        throw new Exception('unable to retrieve vk post id');
    }

    /**
     * @param $vk_post_data
     * @param ImageUploader $uploader
     * @return News
     * @throws Exception
     */
    abstract protected function tryCreateNewItemFromVkPostData($vk_post_data, ImageUploader $uploader);
}
