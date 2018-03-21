<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;

/**
 * Class RefreshToken
 * @package AppBundle\Entity
 */
class RefreshToken extends BaseRefreshToken
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

