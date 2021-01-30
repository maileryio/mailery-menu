<?php

namespace Mailery\Menu\Decorator;

use Yiisoft\Injector\Injector;

final class Normalizer
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
    public function normalize(array $items): array
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

                foreach ($item as $key => $value) {
                    if (is_callable($value)) {
                        $item[$key] = $this->injector->invoke($value);
                    }
                }

                return $item;
            },
            $items
        );
    }
}
