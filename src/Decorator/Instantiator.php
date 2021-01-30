<?php

namespace Mailery\Menu\Decorator;

use Mailery\Menu\MenuItem;

class Instantiator
{
    /**
     * @param array $items
     * @return array
     */
    public function instantiate(array $items): array
    {
        return $this->processItems($items);
    }

    /**
     * @param array $items
     * @return array
     */
    private function processItems(array $items): array
    {
        return array_map(
            function (array $item) {
                if (!empty($item['items'])) {
                    $item['items'] = $this->processItems($item['items']);
                }

                return MenuItem::fromArray($item);
            },
            $items
        );
    }
}
