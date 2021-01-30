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

use Mailery\Menu\Decorator\Normalizer;
use Mailery\Menu\Decorator\Instantiator;
use Mailery\Menu\Decorator\Sorter;

final class Menu implements MenuInterface
{
    /**
     * @var Sorter
     */
    private Sorter $sorter;

    /**
     * @var Normalizer
     */
    private Normalizer $normalizer;

    /**
     * @var Instantiator
     */
    private Instantiator $instantiator;

    /**
     * @var array
     */
    private array $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param Sorter $sorter
     * @return self
     */
    public function withSorter(Sorter $sorter): self
    {
        $new = clone $this;
        $new->sorter = $sorter;

        return $new;
    }

    /**
     * @param Normalizer $normalizer
     * @return self
     */
    public function withNormalizer(Normalizer $normalizer): self
    {
        $new = clone $this;
        $new->normalizer = $normalizer;

        return $new;
    }

    /**
     * @param Instantiator $instantiator
     * @return self
     */
    public function withInstantiator(Instantiator $instantiator): self
    {
        $new = clone $this;
        $new->instantiator = $instantiator;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(): array
    {
        return $this->instantiator
            ->instantiate(
                $this->normalizer
                    ->normalize(
                        $this->items
                    )
            );
    }
}
