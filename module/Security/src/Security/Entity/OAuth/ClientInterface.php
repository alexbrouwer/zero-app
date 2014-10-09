<?php


namespace Security\Entity\OAuth;

interface ClientInterface
{
    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getSecret();

    /**
     * @return string
     */
    public function getRedirectUri();

    /**
     * @return string|null
     */
    public function getScope();

    /**
     * @return array
     */
    public function getGrantTypes();
}
