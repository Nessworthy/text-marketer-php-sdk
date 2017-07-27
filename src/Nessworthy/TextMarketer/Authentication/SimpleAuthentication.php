<?php
namespace Nessworthy\TextMarketer\Authentication;

class SimpleAuthentication implements Authentication
{
    private $userName;
    private $password;

    /**
     * @param string $userName Your text marketer API user name.
     * @param string $password Your text marketer API password.
     * @throws InvalidAuthenticationException Thrown if the details provided don't pass basic validation.
     */
    public function __construct($userName, $password)
    {
        if (!is_string($userName)) {
            throw new InvalidAuthenticationException(
                sprintf(
                    'A string was expected for your text marketer user name, %s given.',
                    gettype($userName)
                ),
                InvalidAuthenticationException::E_INVALID_USERNAME
            );
        }

        if (strlen($userName) < 6) {
            throw new InvalidAuthenticationException(
                sprintf(
                    'Your text marketer user name should be at least 6 characters, %s given.',
                    strlen($userName)
                ),
                InvalidAuthenticationException::E_INVALID_USERNAME
            );
        }

        if (!is_string($password)) {
            throw new InvalidAuthenticationException(
                sprintf(
                    'A string was expected for your text marketer password, %s given.',
                    gettype($password)
                ),
                InvalidAuthenticationException::E_INVALID_PASSWORD
            );
        }

        if (strlen($password) < 6) {
            throw new InvalidAuthenticationException(
                sprintf(
                    'Your text marketer password should be at least 6 characters, %s given.',
                    strlen($password)
                ),
                InvalidAuthenticationException::E_INVALID_PASSWORD
            );
        }

        $this->userName = $userName;
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

}