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

use Closure;
use Psr\Container\ContainerInterface;

abstract class BaseMenu implements MenuInterface
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $allowedItemKeys = [
        'label',
        'title',
        'encode',
        'url',
        'visible',
        'active',
        'template',
        'submenuTemplate',
        'options',
        'icon',
        'order',
        'activeRoutes',
        'items',
    ];

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
        return $this->sortItems($this->filterItems($this->items));
    }

    /**
     * @param array $items
     * @return array
     */
    private function filterItems(array $items): array
    {
        return array_map(
            function ($item) {
                $item = $this->filterItem($item);

                if (!empty($item['items'])) {
                    $item['items'] = $this->filterItems($item['items']);
                }

                return $item;
            },
            $items
        );
    }

    /**
     * @param array $item
     * @return array
     */
    private function filterItem(array $item): array
    {
        foreach ($item as $key => $value) {
            if ($value instanceof Closure) {
                $item[$key] = call_user_func($value, $this->container, $this);
            }
        }

        return array_intersect_key($item, array_flip($this->allowedItemKeys));
    }

    /**
     * @param array $items
     * @return array
     */
    private function sortItems(array $items): array
    {
        usort(
            $items,
            function ($a, $b) {
                return @$a['order'] < @$b['order'] ? -1 : 1;
            }
        );

        return $items;
    }
}
