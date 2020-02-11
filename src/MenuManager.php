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

class MenuManager implements MenuManagerInterface
{
    /**
     * @var MenuInterface[]
     */
    private $menus = [];

    /**
     * @param MenuInterface $menu
     */
    public function setMenu(MenuInterface $menu)
    {
        $this->menus[$menu->getKey()] = $menu;
    }

    /**
     * @param string $key
     * @return MenuInterface|null
     */
    public function getMenu(string $key): ?MenuInterface
    {
        return $this->menus[$key] ?? null;
    }

    /**
     * @param MenuInterface[] $menus
     */
    public function setMenus($menus)
    {
        foreach ($menus as $menu) {
            $this->setMenu($menu);
        }
    }

    /**
     * @return MenuInterface[]
     */
    public function getMenus(): array
    {
        return $this->menus;
    }
}
