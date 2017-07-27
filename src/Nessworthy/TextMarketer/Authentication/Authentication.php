<?php
namespace Nessworthy\TextMarketer\Authentication;

/**
 * Interface Authentication
 * Represents authentication information to use when interacting with the text marketer API.
 * @package Nessworthy\TextMarketer\Authentication
 */
interface Authentication
{
    /**
     * Retrieve the user name.
     * @return string
     */
    public function getUserName();

    /**
     * Retrieve the password.
     * @return string
     */
    public function getPassword();
}