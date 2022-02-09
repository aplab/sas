<?php namespace App\Component\DataTableRepresentation;


use App\Component\DataTableRepresentation\Pager\Pager;
use App\Component\ModuleMetadata\ModuleMetadata;
use App\Component\SystemState\SystemState;
use App\Util\CssWidthDefinition;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use ReflectionException;

class DataTable
{
    protected string $entityClassName;
    protected ReflectionClass $entityReflectionClass;
    protected EntityManagerInterface $entityManager;
    protected ModuleMetadata $moduleMetadata;

    /** @var DataTableCell[]; */
    protected array $cell;
    protected CssWidthDefinition $cssWidthDefinition;

    /**
     * @var SystemState
     */
    protected $systemState;

    /**
     * READ-ONLY: The field names of all fields that are part of the identifier/primary key
     * of the mapped entity class.
     */
    protected array $identifier;

    public function getIdentifier(): array
    {
        return $this->identifier;
    }

    public function helperIdentifierJson($item): bool|string
    {
        $data = [];
        foreach ($this->identifier as $i) {
            $getter = 'get' . ucfirst($i);
            $data[$i] = $item->$getter();
        }
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function __construct(ReflectionClass         $entity_reflection_class,
                                DataTableRepresentation $data_table_representation)
    {
        $this->entityReflectionClass = $entity_reflection_class;
        $this->entityClassName = $this->entityReflectionClass->getName();
        $this->entityManager = $data_table_representation->getEntityManager();
        $this->moduleMetadata = $data_table_representation->getModuleMetadataRepository()
            ->getMetadata($this->entityClassName);
        $this->cssWidthDefinition = $data_table_representation->getCssWidthDefinition();
        $this->systemState = $data_table_representation->getSystemStateManager()
            ->get()->get($this->entityClassName . __CLASS__);
        $this->identifier = $this->entityManager->getClassMetadata($this->entityClassName)->identifier;
        $this->initCell();
    }

    /** @return DataTableCell[] */
    public function getCell(): array
    {
        if (is_null($this->cell)) {
            $this->initCell();
        }
        return $this->cell;
    }

    protected function initCell(): void
    {
        $this->cell = [];
        $properties = $this->moduleMetadata->getProperties();
        foreach ($properties as $property_name => $property_metadata) {
            $cell_metadata_list = $property_metadata->getCell();
            $property = $this->entityReflectionClass->getProperty($property_name);
            foreach ($cell_metadata_list as $cell_metadata) {
                $this->cssWidthDefinition->add($cell_metadata->getWidth());
                $this->cell[] = new DataTableCell($this, $property, $property_metadata, $cell_metadata);
            }
        }
        usort($this->cell, function (DataTableCell $a, DataTableCell $b) {
            return $a->getOrder() <=> $b->getOrder();
        });
    }

    /**
     * Temporary stub
     * @return object[]
     */
    public function getItems(): array
    {
        $pager = $this->getPager();
        return $this->entityManager->getRepository($this->entityClassName)->findBy(
            [],
            ['id' => 'DESC'],
            $pager->getItemsPerPage(),
            $pager->getOffset()
        );
    }

    protected ?int $count = null;

    public function getCount(): int
    {
        if (is_null($this->count)) {
            $this->count = $this->entityManager->getRepository($this->entityClassName)->count([]);
        }
        return $this->count;
    }

    protected ?Pager $pager = null;

    public function getPager(): Pager
    {
        if (is_null($this->pager)) {
            $pager = $this->systemState->get('pager');
            if ($pager instanceof Pager) {
                $this->pager = $pager;
                $pager->setCount($this->getCount());
            } else {
                $this->pager = new Pager($this->getCount());
                $this->systemState->pager = $this->pager;
            }
        }
        return $this->pager;
    }

    public function getEntityClassName(): string
    {
        return $this->entityClassName;
    }

    public function getEntityReflectionClass(): ReflectionClass
    {
        return $this->entityReflectionClass;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getModuleMetadata(): ModuleMetadata
    {
        return $this->moduleMetadata;
    }

    public function getCssWidthDefinition(): CssWidthDefinition
    {
        return $this->cssWidthDefinition;
    }

    public function getSystemState(): SystemState
    {
        return $this->systemState;
    }
}
