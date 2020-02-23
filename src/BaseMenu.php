<?php

declare(strict_types=1);

/**
 * Mailery Menu module
 * @link      https://github.com/maileryio/mailery-menu
 * @package   Mailery\Menu
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Menu;

use Psr\Container\ContainerInterface;

abstract class BaseMenu implements MenuInterface
{
    /**
     * @var MenuItem[]
     */
    private $items = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(): array
    {
        return $this->sortItems($this->processItems($this->items));
    }

    /**
     * @param MenuItem[] $items
     * @return MenuItem[]
     */
    private function processItems(array $items): array
    {
        return array_map(
            function (MenuItem $item) {
                $item = $item->withContainer($this->container);

                $childItems = $item->getChildItems();
                if (!empty($childItems)) {
                    return $item->withChildItems(
                        $this->sortItems(
                            $this->processItems($childItems)
                        )
                    );
                }

                return $item;
            },
            $items
        );
    }

    /**
     * @param MenuItem[] $items
     * @return MenuItem[]
     */
    private function sortItems(array $items): array
    {
        usort(
            $items,
            function (MenuItem $a, MenuItem $b) {
                return $a->getOrder() < $b->getOrder() ? -1 : 1;
            }
        );

        return $items;
    }
}
