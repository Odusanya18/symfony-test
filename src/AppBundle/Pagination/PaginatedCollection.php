<?php

namespace AppBundle\Pagination;

class PaginatedCollection
{
    /**
     * @var array
     */
    public $items;

    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $currentPage;

    /**
     * @var int
     */
    public $count;

    /**
     * @var array
     */
    public $_links = array();

    /**
     * @param array $items
     * @param int $total
     * @param int $page
     */
    public function __construct(array $items, $totalItems, $page)
    {
        $this->items = $items;
        $this->total = $totalItems;
        $this->count = count($items);
        $this->currentPage = $page;
    }

    /**
     * @param string $ref
     * @param string $url
     */
    public function addLink($ref, $url)
    {
        $this->_links[$ref] = $url;
    }
}