<?php

declare(strict_types=1);

/**
 * Mailery Menu module
 * @link      https://github.com/maileryio/mailery-menu
 * @package   Mailery\Menu
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Menu\Factory;

use Mailery\Menu\MenuInterface;
use Psr\Container\ContainerInterface;

class MenusProviderFactory
{
    /**
     * @var array
     */
    private $menus;

    public function __construct(/* $menus */)
    {
        $this->menus = \func_get_args();
    }

    /**
     * @param ContainerInterface $container
     * @return MenuInterface[]
     */
    public function __invoke(ContainerInterface $container): array
    {
        return array_map(
            function ($menu) use ($container) {
                if ($menu instanceof MenuInterface) {
                    return $menu;
                }

                return $container->get($menu);
            },
            $this->menus
        );
    }
}
