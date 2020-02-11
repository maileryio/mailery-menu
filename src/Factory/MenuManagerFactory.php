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

use Mailery\Menu\MenuManager;
use Mailery\Menu\MenuManagerInterface;
use Psr\Container\ContainerInterface;

class MenuManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return MenuManagerInterface
     */
    public function __invoke(ContainerInterface $container): MenuManagerInterface
    {
        /** @var MenusProviderFactory $menusProvider */
        $menusProvider = $container->get(MenusProviderFactory::class);
        $menus = $menusProvider($container);

        $menuManager = new MenuManager();
        $menuManager->setMenus($menus);

        return $menuManager;
    }
}
