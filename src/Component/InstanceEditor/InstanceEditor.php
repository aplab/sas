<?php namespace App\Component\InstanceEditor;

use App\Component\InstanceEditor\FieldType\FieldTypeEntity;
use App\Component\ModuleMetadata\ModuleMetadata;
use App\Component\ModuleMetadata\ModuleMetadataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

class InstanceEditor
{
    const REQUEST_KEY = 'apl-instance-editor';
    protected object $entity;
    protected InstanceEditorManager $instanceEditorManager;
    protected ModuleMetadataRepository $moduleMetadataRepository;
    protected EntityManagerInterface $entityManagerInterface;
    protected ModuleMetadata $moduleMetadata;
    protected ClassMetadata $classMetadata;

    /** @var InstanceEditorField[] */
    protected array $widget;

    /** @var InstanceEditorTab[] */
    protected array $tab;

    /**
     * READ-ONLY: The field names of all fields that are part of the identifier/primary key
     * of the mapped entity class.
     */
    protected array $identifier;

    public function getIdentifier(): array
    {
        return $this->identifier;
    }

    public function helperIdentifierJson(): bool|string
    {
        $data = [];
        foreach ($this->identifier as $i) {
            $getter = 'get' . ucfirst($i);
            $data[$i] = $this->entity->$getter();
        }
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function __construct(object $entity, InstanceEditorManager $instance_editor_manager)
    {
        $this->entity = $entity;
        $this->instanceEditorManager = $instance_editor_manager;
        $this->moduleMetadataRepository = $instance_editor_manager->getModuleMetadataRepository();
        $this->entityManagerInterface = $instance_editor_manager->getEntityManagerInterface();
        $this->moduleMetadata = $this->moduleMetadataRepository->getMetadata($this->entity);
        $this->classMetadata = $this->entityManagerInterface->getClassMetadata($this->moduleMetadata->getClassName());
        $this->identifier = $this->classMetadata->identifier;
        $this->configure();
    }

    /**
     * Configure Instance editor
     */
    protected function configure()
    {
        $this->configureFields();
        $this->configureTabs();
    }

    /**
     * First configure fields
     */
    protected function configureFields()
    {
        $this->widget = [];
        $properties = $this->moduleMetadata->getProperties();
        foreach ($properties as $property_name => $property_metadata) {
            $widget_metadata_list = $property_metadata->getWidget();
            $property = $this->classMetadata->getReflectionClass()->getProperty($property_name);
            foreach ($widget_metadata_list as $widget_metadata) {
                $this->widget[] = new InstanceEditorField($this, $property, $property_metadata,
                    $widget_metadata);
            }
        }
        usort($this->widget, function (InstanceEditorField $a, InstanceEditorField $b) {
            return $a->getOrder() <=> $b->getOrder();
        });
    }

    /**
     * configure tabs
     */
    protected function configureTabs()
    {
        $tab_order_configuration = $this->moduleMetadata->getModule()->getTabOrder();
        $tab_names = [];
        // find required tabs
        foreach ($this->widget as $widget) {
            $tab_name = $widget->getTab();
            if (!isset($tab_names[$tab_name])) {
                $tab_names[$tab_name] = $tab_name;
            }
        }
        // create tabs
        $number = 0;
        foreach ($tab_names as $tab_name) {
            $tab = new InstanceEditorTab;
            $this->tab[] = $tab;
            $tab->setName($tab_name);
            $tab->setOrder($tab_order_configuration[$tab_name] ?? $number++);
        }
        // building tab index
        /** @var InstanceEditorTab[] */
        $tab_index = [];
        foreach ($this->tab as $tab) {
            $tab_name = $tab->getName();
            $tab_index[$tab_name] = $tab;
        }
        usort($this->tab, function (InstanceEditorTab $a, InstanceEditorTab $b) {
            return $a->getOrder() <=> $b->getOrder();
        });
        // distribute widgets to tabs
        foreach ($this->widget as $widget) {
            $tab_name = $widget->getTab();
            if (isset($tab_index[$tab_name])) {
                $tab_index[$tab_name]->addField($widget);
            }
        }
    }

    public function handleRequest(Request $request)
    {
        $data = $request->request->all(static::REQUEST_KEY, []);
        if (empty($data)) {
            return;
        }
        $entity = $this->getEntity();
        foreach ($this->getWidget() as $widget) {
            $property_name = $widget->getPropertyName();
            if (!array_key_exists($property_name, $data)) {
                continue;
            }
            $type = $widget->getType();
            if ($type instanceof FieldTypeEntity) {
                $class = $type->getEntityClass();
                $repository = $this->entityManagerInterface->getRepository($class);
                $value = $repository->find($data[$property_name]);
            } else {
                $value = $data[$property_name];
            }
            $setter = 'set' . ucfirst($property_name);
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }
//        $validator = $this->instanceEditorManager->getValidatorInterface();
//        $constraint_violations = $validator->validate($entity);
//        if (sizeof($constraint_violations)) {
//            throw new Exception($constraint_violations);
//        }
        $this->getEntityManagerInterface()->persist($entity);
        $this->getEntityManagerInterface()->flush();
    }

    public function getEntity(): object
    {
        return $this->entity;
    }

    public function getModuleMetadataRepository(): ModuleMetadataRepository
    {
        return $this->moduleMetadataRepository;
    }

    public function getEntityManagerInterface(): EntityManagerInterface
    {
        return $this->entityManagerInterface;
    }

    public function getModuleMetadata(): ModuleMetadata
    {
        return $this->moduleMetadata;
    }

    public function getClassMetadata(): ClassMetadata
    {
        return $this->classMetadata;
    }

    public function getWidget(): array
    {
        return $this->widget;
    }

    public function getTab(): array
    {
        return $this->tab;
    }

    public function getInstanceEditorManager(): InstanceEditorManager
    {
        return $this->instanceEditorManager;
    }
}
