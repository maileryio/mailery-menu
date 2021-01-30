<?php

namespace Mailery\Menu\Decorator;

use Mailery\Menu\MenuItem;

final class Sorter
{
    /**
     * @param array $items
     * @return array
     */
    public function sort(array $items): array
    {
        return $this->processItems($items);
    }

    /**
     * @param array $items
     * @return array
     */
    private function processItems(array $items): array
    {
        usort(
            $items,
            function ($a, $b) {
                return $this->retrieveOrder($a) < $this->retrieveOrder($b) ? -1 : 1;
            }
        );

        return $items;
    }

    /**
     * @param MenuItem|array $item
     * @return int
     */
    private function retrieveOrder($item): int
    {
        if ($item instanceof MenuItem) {
            return $item->getOrder();
        }
        return $item['order'] ?? 0;
    }
}
