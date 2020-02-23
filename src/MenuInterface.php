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

interface MenuInterface
{
    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param MenuItem[] $items
     */
    public function setItems(array $items);

    /**
     * @return MenuItem[]
     */
    public function getItems(): array;
}
