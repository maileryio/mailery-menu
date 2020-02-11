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

interface MenuManagerInterface
{
    /**
     * @param MenuInterface $menu
     */
    public function setMenu(MenuInterface $menu);

    /**
     * @param string $key
     * @return MenuInterface|null
     */
    public function getMenu(string $key): ?MenuInterface;

    /**
     * @param MenuInterface[] $menus
     */
    public function setMenus($menus);

    /**
     * @return MenuInterface[]
     */
    public function getMenus(): array;
}
