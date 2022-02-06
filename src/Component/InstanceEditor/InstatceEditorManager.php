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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InstatceEditorManager
{
    protected ModuleMetadataRepository $moduleMetadataRepository;

    protected EntityManagerInterface $entityManagerInterface;

    protected ValidatorInterface $validatorInterface;

    public function __construct(ModuleMetadataRepository $module_metadata_repository,
                                EntityManagerInterface   $entity_manager_interface,
                                ValidatorInterface       $validator_interface)
    {
        $this->moduleMetadataRepository = $module_metadata_repository;
        $this->entityManagerInterface = $entity_manager_interface;
        $this->validatorInterface = $validator_interface;
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
}
