<?php namespace App\Component\DataTableRepresentation\Pager;

use Respect\Validation\Validator;

class Pager
{
    const ITEMS_PER_PAGE_DEFAULT = 100;

    private int $count;

    private int $itemsPerPage;

    private array $itemsPerPageVariants = [
        10,
        50,
        100,
        200,
        500
    ];

    public function __construct(int $count)
    {
        $this->count = $count;
        $this->itemsPerPage = static::ITEMS_PER_PAGE_DEFAULT;
        $this->currentPage = 1;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getItemsPerPageVariants(): array
    {
        return $this->itemsPerPageVariants;
    }

    public function setItemsPerPage(int $items_per_page): Pager
    {
        if (in_array($items_per_page, $this->itemsPerPageVariants)) {
            $this->itemsPerPage = $items_per_page;
        } else {
            $this->itemsPerPage = static::ITEMS_PER_PAGE_DEFAULT;
        }
        return $this;
    }

    public function setItemsPerPageVariants(array $items_per_page_variants): Pager
    {
        Validator::arrayType()->each(Validator::digit())->check($items_per_page_variants);
        $this->itemsPerPageVariants = $items_per_page_variants;
        return $this;
    }

    public function getPages(): array
    {
        return range(1, ceil($this->count / $this->itemsPerPage));
    }

    private int $currentPage;

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): Pager
    {
        $this->count = $count;
        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): Pager
    {
        $pages = $this->getPages();
        if (in_array($currentPage, $pages)) {
            $this->currentPage = $currentPage;
        } else {
            $this->currentPage = 1;
        }
        return $this;
    }

    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getPrev(): ?int
    {
        return ($this->currentPage > 1) ? ($this->currentPage - 1) : null;
    }

    public function getNext(): ?int
    {
        return ($this->currentPage < ceil($this->count / $this->itemsPerPage)) ? ($this->currentPage + 1) : null;
    }
}
