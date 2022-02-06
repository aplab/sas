<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 26.08.2018
 * Time: 14:58
 */

namespace App\Controller;


use App\Entity\AdjacencyList\ListItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExampleController
 * @package App\Controller
 */
#[Route(path: '/', name: '')]
class ExampleController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route(path: '/test', name: 'test')]
    public function test()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(ListItem::class);
        //        $items = $repo->findAll();
        //        foreach ($items as $item) {
        //            $item->setName(bin2hex(random_bytes(10)));
        //            $em->persist($item);
        //        }
        //        $root = $repo->find(1);
        //        $child = $repo->find(2);
        ////        $root->addChild($child);
        //
        ////
        //        $em->flush();
        //        $roots = $repo->getRoots();
        return $this->render('admin-test.html.twig', get_defined_vars());
    }
}
