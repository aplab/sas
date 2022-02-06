<?php

namespace App\Repository\Site;

use App\Entity\PageTreeItem;
use App\Entity\Site\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    /**
     * SectionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    /**
     * @return array
     */
    public function get2d()
    {
        $items = $this->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC']);
        $result = [];
        foreach ($items as $item) {
            $parent = $item->getParent();
            $result[$parent ? $parent->getId() : 0][$item->getId()] = $item;
        }
        return $result;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRoots()
    {
        return $this->createQueryBuilder('t')
            ->where('t.parent is null')
            ->orderBy('t.sortOrder', 'ASC')
            ->addOrderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $limit
     * @param $offset
     * @return Section[]
     */
    public function rootPage($limit, $offset)
    {
        $children = $this->findBy(
            ['parent' => null],
            ['sortOrder' => 'ASC', 'id' => 'ASC'], $limit, $offset);
        $level = 0;
        $tmp = [];
        while ($children) {
            foreach ($children as $child) {
                $child->level = $level;
                $tmp[] = $child;
            }
            $children = $this->getChildrenOf($children);
            $level++;
        }
        $tmp = $this->to2d($tmp);
        $ret = array();
        $level = 0;
        $to_list = function ($from_key = 0) use (& $ret, $tmp, & $to_list, & $level) {
            if (!isset($tmp[$from_key])) return;
            foreach ($tmp[$from_key] as $k => $v) {
                $v->levelCheck = $level;
                $ret[$k] = $v;
                if (isset($tmp[$k])) {
                    $level++;
                    $to_list($k);
                    $level--;
                }
            }
        };
        $to_list(0);
        return $ret;
    }

    /**
     * @return int
     */
    public function getRootsCount()
    {
        return $this->count(['parent' => null]);
    }

    /**
     * @param Section[] $items
     * @return Section[]
     */
    public function getChildrenOf(array $items)
    {
        return $this->findBy(['parent' => $items], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }

    /**
     * @return array|mixed
     */
    public function getTree()
    {
        $tmp = $this->get2d();
        $roots = $tmp[0] ?? [];
        if (empty($roots)) {
            return $roots;
        }
        $ret = array();
        $level = 0;
        $to_list = function ($from_key = 0) use (& $ret, $tmp, & $to_list, & $level) {
            if (!isset($tmp[$from_key])) return;
            foreach ($tmp[$from_key] as $k => $v) {
                $v->level = $level;
                $ret[$k] = $v;
                if (isset($tmp[$k])) {
                    $level++;
                    $to_list($k);
                    $level--;
                }
            }
        };
        $to_list(0);
        return $ret;
    }

    /**
     * @param Section[] $items
     * @return Section[]
     */
    public function to2d(array $items)
    {
        $result = [];
        foreach ($items as $item) {
            $parent = $item->getParent();
            $result[$parent ? $parent->getId() : 0][$item->getId()] = $item;
        }
        return $result;
    }

    /**
     * @param null $selected
     * @return array|mixed
     */
    public function getOptionsDataList($selected = null)
    {
        $tmp = $this->getTree();
        array_walk($tmp, function ($v, $k) use (& $tmp, $selected) {
            $tmp[$k] = array(
                'value' => $k,
                'text' => str_repeat(html_entity_decode('&bull;') . ' ', $v->level) . '[' . $k . '] ' . $v->getName(),
                'selected' => $v === $selected
            );
        });
        return $tmp;
    }
}
