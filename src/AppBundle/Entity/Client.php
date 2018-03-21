<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;

/**
 * Class Client
 * @package AppBundle\Entity
 */
class Client extends BaseClient
{
    /**
     * @var int
     */
    protected $id;

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
     * Client constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}

