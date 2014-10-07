<?php


namespace OAuth\Entity;

interface UserInterface
{
    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string|null
     */
    public function getScope();

    /**
     * @return string
     */
    public function getPassword();
}
