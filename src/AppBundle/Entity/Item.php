<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Item
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection of Category
     */
    protected $categories;

    /**
     * @var
     */
    protected $itemValues;
    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->itemValues = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     */
    public function setCategories(Collection $categories)
    {
            $this->categories = $categories;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getItemValues()
    {
        return $this->itemValues;
    }

    /**
     * @param Collection $itemValues
     */
    public function setItemValues(Collection $itemValues)
    {
        $this->itemValues = $itemValues;
    }

}

