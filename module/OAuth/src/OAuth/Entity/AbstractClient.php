<?php


namespace OAuth\Entity;

abstract class AbstractClient implements ClientInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $secret = '';

    /**
     * @var string|null
     */
    protected $scope;

    /**
     * @var array|null
     */
    protected $grantTypes = null;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * Get Identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return AbstractClient
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get Secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set secret
     *
     * @param string $secret
     *
     * @return AbstractClient
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get RedirectUrl
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set redirectUri
     *
     * @param string $redirectUri
     *
     * @return AbstractClient
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * Get Scope
     *
     * @return null|string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set scope
     *
     * @param null|string $scope
     *
     * @return AbstractClient
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get GrantTypes
     *
     * @return array
     */
    public function getGrantTypes()
    {
        return $this->grantTypes;
    }

    /**
     * Set grantTypes
     *
     * @param array $grantTypes
     *
     * @return AbstractClient
     */
    public function setGrantTypes(array $grantTypes = null)
    {
        $this->grantTypes = $grantTypes;

        return $this;
    }
}
