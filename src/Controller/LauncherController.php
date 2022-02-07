<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 18.08.2018
 * Time: 9:46
 */

namespace App\Controller;


use App\Component\ActionMenu\ActionMenuManager;
use App\Component\Launcher\Launcher;
use App\Component\Menu\MenuManager;
use App\Component\Toolbar\ToolbarManager;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LauncherController extends AbstractController
{
    /**
     * 4*6
     */
    const ITEMS_PER_PAGE = 24;

    public function launcher(Launcher $launcher): Response
    {
        $data = $launcher->getData();
        $data_by_sort_order = [];
        $pages = [];
        foreach ($data as $item) {
            $sort_order = $item->getSortOrder();
            while(array_key_exists($sort_order, $data_by_sort_order)) {
                $sort_order++;
            }
            $data_by_sort_order[$sort_order] = $item;
            $page_number = floor($sort_order / self::ITEMS_PER_PAGE);
            $order_on_page = $sort_order % self::ITEMS_PER_PAGE;
            $pages[$page_number][$order_on_page] = $item;
        }
        return $this->render(
            'launcher.html.twig', [
                'data' => $pages,
            ]
        );
    }
}
