<?php

namespace Mailery\Menu;

use Psr\Container\ContainerInterface;
use Opis\Closure\SerializableClosure;
use Yiisoft\Injector\Injector;
use Yiisoft\Router\UrlMatcherInterface;

class MenuItem
{
    /**
     * @var string|\Closure|null
     */
    private $url = null;

    /**
     * @var string|\Closure|null
     */
    private $label = null;

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
    private array $childItems = [];

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var array
     */
    private array $activeRouteNames = [];

    /**
     * @param string|\Closure $url
     * @return self
     */
    public function withUrl($url): self
    {
        $new = clone $this;
        $new->url = $url;
        return $new;
    }

    /**
     * @param string|\Closure $label
     * @return self
     */
    public function withLabel($label): self
    {
        $new = clone $this;
        $new->label = $label;
        return $new;
    }

    /**
     * @param string $icon
     * @return self
     */
    public function withIcon(string $icon): self
    {
        $new = clone $this;
        $new->icon = $icon;
        return $new;
    }

    /**
     * @param int $order
     * @return self
     */
    public function withOrder(int $order): self
    {
        $new = clone $this;
        $new->order = $order;
        return $new;
    }

    /**
     * @param MenuItem[] $childItems
     * @return self
     */
    public function withChildItems(array $childItems): self
    {
        $new = clone $this;
        $new->childItems = $childItems;
        return $new;
    }

    /**
     * @param ContainerInterface $container
     * @return self
     */
    public function withContainer(ContainerInterface $container): self
    {
        $new = clone $this;
        $new->container = $container;
        return $new;
    }

    /**
     * @param array $activeRouteNames
     * @return \self
     */
    public function withActiveRouteNames(array $activeRouteNames): self
    {
        $new = clone $this;
        $new->activeRouteNames = $activeRouteNames;
        return $new;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        if (empty($this->activeRouteNames)) {
            return null;
        }

        /* @var $urlMatcher UrlMatcherInterface */
        $urlMatcher = $this->container->get(UrlMatcherInterface::class);

        return in_array(
            $urlMatcher->getCurrentRoute()->getName(),
            $this->activeRouteNames
        );
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->tryClosureValue($this->url);
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->tryClosureValue($this->label);
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return MenuItem[]
     */
    public function getChildItems(): array
    {
        return $this->childItems;
    }

    /**
     * @param array $childItems
     * @return self
     */
    public function setChildItems(array $childItems): self
    {
        $this->childItems = $childItems;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'url' => $this->getUrl(),
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
            'order' => $this->getOrder(),
            'active' => $this->getActive(),
            'childItems' => $this->getChildItems(),
        ];
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function tryClosureValue($value)
    {
        if ($value instanceof SerializableClosure) {
            $value = $value->getClosure();
        }

        if ($value instanceof \Closure) {
            return (new Injector($this->container))->invoke($value, [$this]);
        }

        return $value;
    }

}