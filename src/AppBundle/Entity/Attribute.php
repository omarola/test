<?php

namespace AppBundle\Entity;

/**
 * Attribute
 */
class Attribute
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $name;

    /**
     * @var
     */
    protected $attrValues;

    /**
     * @return mixed
     */
    public function getAttrValues()
    {
        return $this->attrValues;
    }

    /**
     * @param mixed $attrValues
     */
    public function setAttrValues($attrValues)
    {
        $this->attrValues = $attrValues;
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
     * Set alias
     *
     * @param string $alias
     *
     * @return Attribute
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Attribute
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
}

