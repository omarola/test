<?php

namespace AppBundle\Entity;

/**
 * Class AuthCode
 * @package AppBundle\Entity
 */
class AuthCode
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Relation to Client Entity
     */
    protected $client;

    /**
     * Relation to User Entity
     */
    protected $user;
}

