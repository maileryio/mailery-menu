<?php

namespace Mailery\Menu\Decorator;

use Mailery\Menu\MenuItem;
use Yiisoft\Injector\Injector;
use Yiisoft\Router\CurrentRoute;

final class Instantiator
{
    /**
     * @var Injector
     */
    private Injector $injector;

    /**
     * @param Injector $injector
     */
    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

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

                return $this->injector->invoke(function (CurrentRoute $currentRoute) use($item) {
                    return MenuItem::fromArray($item)
                        ->withCurrentRoute($currentRoute);
                });
            },
            $items
        );
    }
}
