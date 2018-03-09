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
    protected $attributes;
    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->attributes = new ArrayCollection();
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
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param Collection $attributes
     */
    public function setAttributes(Collection $attributes)
    {
        $this->attributes = $attributes;
    }

}

