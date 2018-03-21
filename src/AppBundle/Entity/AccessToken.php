<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

/**
 * Class AccessToken
 * @package AppBundle\Entity
 */
class AccessToken extends BaseAccessToken
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

