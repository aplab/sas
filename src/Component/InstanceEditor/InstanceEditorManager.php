<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 27.08.2018
 * Time: 20:42
 */

namespace App\Component\InstanceEditor;


use App\Component\ModuleMetadata\ModuleMetadataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InstanceEditorManager
{
    protected ModuleMetadataRepository $moduleMetadataRepository;
    protected EntityManagerInterface $entityManagerInterface;
    protected ValidatorInterface $validatorInterface;
    protected RouterInterface $router;

    public function __construct(ModuleMetadataRepository $m, EntityManagerInterface $e, ValidatorInterface $v, RouterInterface $r)
    {
        $this->moduleMetadataRepository = $m;
        $this->entityManagerInterface = $e;
        $this->validatorInterface = $v;
        $this->router = $r;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException|\Psr\Cache\InvalidArgumentException
     */
    public function getInstanceEditor(object $entity): InstanceEditor
    {
        return new InstanceEditor($entity, $this);
    }

    public function getModuleMetadataRepository(): ModuleMetadataRepository
    {
        return $this->moduleMetadataRepository;
    }

    public function getEntityManagerInterface(): EntityManagerInterface
    {
        return $this->entityManagerInterface;
    }

    public function getValidatorInterface(): ValidatorInterface
    {
        return $this->validatorInterface;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
