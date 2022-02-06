<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 26.08.2018
 * Time: 15:00
 */

namespace App\Controller;


use App\Component\Helper\EntityControllerHelper;
use App\Component\ModuleMetadata\Module;
use LogicException;
use ReflectionClass;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class BaseAdminController
 * @package App\Controller
 */
abstract class EntityController extends AbstractController
{
    protected EntityControllerHelper $adminControllerHelper;

    /**
     * @var Route
     */
    protected $routeAnnotation;

    protected ReflectionClass $entityClass;

    /**
     * BaseAdminController constructor.
     * @param EntityControllerHelper $adminControllerHelper
     * @throws ReflectionException
     */
    public function __construct(EntityControllerHelper $adminControllerHelper)
    {
        $this->adminControllerHelper = $adminControllerHelper;
        if (!isset($this->entityClassName)) {
            throw new LogicException(get_class($this) . ' must have a protected $entityClassName = Entity::class');
        }
        $this->entityClass = new ReflectionClass($this->getEntityClassName());
        $attr = $this->entityClass->getAttributes(Module::class);
        if (sizeof($attr)) {
            $attr = reset($attr);
        }
        if ($attr instanceof \ReflectionAttribute) {
            $attr = $attr->newInstance();
        }
        $title = $this->getEntityClass()->getShortName();
        if ($attr instanceof Module) {
            $title = $attr->getTitle();
        }
        $this->adminControllerHelper->getHtmlTitle()->setTitle($title);
        $this->routeAnnotation = (new ReflectionClass(static::class))->getAttributes(Route::class)[0]->newInstance();
    }

    /**
     * @return mixed
     */
    public function getEntityClassName() {
        return $this->entityClassName;
    }

    /**
     * @return EntityControllerHelper
     */
    public function getAdminControllerHelper(): EntityControllerHelper
    {
        return $this->adminControllerHelper;
    }

    /**
     * @return ReflectionClass
     */
    public function getEntityClass(): ReflectionClass
    {
        return $this->entityClass;
    }



    /**
     * @return Route
     */
    public function getRouteAnnotation(): Route
    {
        return $this->routeAnnotation;
    }

    /**
     * @param $routename
     * @return mixed
     */
    protected function routeToControllerName($routename) {
        $routes = $this->get('router')->getRouteCollection();
        return $routes->get($routename)->getDefaults()['_controller'];
    }
}
