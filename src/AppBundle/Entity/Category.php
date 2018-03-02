<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var Category
     */
    private $parent;

    /**
     * @var ArrayCollection
     */
    private $children;

    /**
     * @var Collection of Item
     */
    protected $items;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Collection $items
     */
    public function setItems(Collection $items)
    {
        $this->items = $items;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}

