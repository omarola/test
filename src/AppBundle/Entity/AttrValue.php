<?php

namespace AppBundle\Entity;

/**
 * AttrValue
 */
class AttrValue
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var
     */
    protected $attribute;

    /**
     * @var
     */
    protected $item;

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
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
     * Set value
     *
     * @param string $value
     *
     * @return AttrValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

