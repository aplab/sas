<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Entity\Admin;
use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route(path: '/admin', name: 'admin_')]
class AdminController extends ReferenceController
{
    protected string $entityClassName = Admin::class;

    public function setPasswordEncoder(UserPasswordEncoderInterface $passwordEncoder)
    {
        $class = $this->entityClassName;
        $class::setPasswordEncoder($passwordEncoder);
    }

    #[Route(path: '/del', name: 'drop', methods: ['POST'])]
    public function dropItem(): RedirectResponse
    {
        $user = $this->getUser();
        $class = $this->getEntityClassName();
        $entity_manager = $this->getDoctrine()->getManager();
        $class_metadata = $entity_manager->getClassMetadata($class);
        $pk = $class_metadata->getIdentifier();
        /**
         * @TODO composite key support
         */
        if (empty($pk)) {
            throw new RuntimeException('identifier not found');
        }
        if (sizeof($pk) > 1) {
            throw new RuntimeException('composite identifier not supported');
        }
        $key = reset($pk);
        $ids = $_POST[$key];
        $ids = json_decode($ids);
        $items = $entity_manager->getRepository($class)->findBy([$key => $ids]);
        foreach ($items as $item) {
            if ($item === $user) {
                $this->addFlash('warning', 'You can not delete the current user of the system.');
            } else {
                $entity_manager->remove($item);
            }
        }
        $entity_manager->flush();
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }
}
