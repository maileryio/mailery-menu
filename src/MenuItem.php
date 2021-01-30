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

class MenuItem
{
    /**
     * @var string|null
     */
    private ?string $url = null;

    /**
     * @var string|null
     */
    private ?string $label = null;

    /**
     * @var string|null
     */
    private ?string $icon = null;

    /**
     * @var int
     */
    private int $order = 0;

    /**
     * @var MenuItem[]
     */
    private array $items = [];

    /**
     * @var array
     */
    private array $activeRouteNames = [];

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        if (empty($this->activeRouteNames)) {
            return null;
        }
return null;
        /* @var $urlMatcher UrlMatcherInterface */
        $urlMatcher = $this->container->get(UrlMatcherInterface::class);

        return in_array(
            $urlMatcher->getCurrentRoute()->getName(),
            $this->activeRouteNames,
            true
        );
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return self
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return self
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return self
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return MenuItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return self
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return array
     */
    public function getActiveRouteNames(): array
    {
        return $this->activeRouteNames;
    }

    /**
     * @param array $activeRouteNames
     * @return self
     */
    public function setActiveRouteNames(array $activeRouteNames): self
    {
        $this->activeRouteNames = $activeRouteNames;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'url' => $this->getUrl() ?? '#',
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
            'order' => $this->getOrder(),
            'active' => $this->getActive(),
            'items' => array_map(
                fn ($item) => $item->toArray(),
                $this->getItems()
            ),
        ];
    }

    /**
     * @param array $values
     * @return self
     */
    public static function fromArray(array $values): self
    {
        $object = new MenuItem();

        foreach ($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }

        return $object;
    }
}
