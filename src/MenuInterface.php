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
    public function getKey(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param array $items
     */
    public function setItems(array $items);

    /**
     * @return array
     */
    public function getItems(): array;
}
