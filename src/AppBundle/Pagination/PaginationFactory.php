<?php

namespace AppBundle\Pagination;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class PaginationFactory
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     * @param string $route
     * @param array $routeParams
     * @return PaginatedCollection
     */
    public function createCollection(QueryBuilder $qb, Request $request, $route, array $routeParams = array())
    {
        /**
         * @var int $page
         * @var DoctrineORMAdapter $adapter
         * @var Pagerfanta $pagerfanta
         * @var array $products
         * @var PaginatedCollection $paginatedCollection
         * @var string $createLinkUrl
         */
        $page = $request->query->getInt('page', 1);

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(2);
        $pagerfanta->setCurrentPage($page);

        $products = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $products[] = $result;
        }

        $paginatedCollection = new PaginatedCollection($products, $pagerfanta->getNbResults(), $page);

        // make sure query parameters are included in pagination links
        $routeParams = array_merge($routeParams, $request->query->all());

        $createLinkUrl = function($targetPage) use ($route, $routeParams) {
            return $this->router->generate($route, array_merge(
                $routeParams,
                array('page' => $targetPage)
            ));
        };

        $paginatedCollection->addLink('self', $createLinkUrl($page));
        $paginatedCollection->addLink('first', $createLinkUrl(1));
        $paginatedCollection->addLink('last', $createLinkUrl($pagerfanta->getNbPages()));
        if ($pagerfanta->hasNextPage()) {
            $paginatedCollection->addLink('next', $createLinkUrl($pagerfanta->getNextPage()));
        }
        if ($pagerfanta->hasPreviousPage()) {
            $paginatedCollection->addLink('prev', $createLinkUrl($pagerfanta->getPreviousPage()));
        }

        return $paginatedCollection;
    }
}