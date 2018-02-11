<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Authentication;

final class Simple implements Authentication
{
    private $userName;
    private $password;

    /**
     * @param string $userName Your text marketer API user name.
     * @param string $password Your text marketer API password.
     * @throws InvalidAuthenticationException Thrown if the details provided don't pass basic validation.
     */
    public function __construct(string $userName, string $password)
    {
        if (\strlen($userName) < 5) {
            throw new InvalidAuthenticationException(
                sprintf(
                    'Your text marketer user name should be at least 5 characters, %s given.',
                    \strlen($userName)
                ),
                InvalidAuthenticationException::E_INVALID_USERNAME
            );
        }

        if (\strlen($password) < 5) {
            throw new InvalidAuthenticationException(
                sprintf(
                    'Your text marketer password should be at least 5 characters, %s given.',
                    \strlen($password)
                ),
                InvalidAuthenticationException::E_INVALID_PASSWORD
            );
        }

        // TODO: U/N + P/W are <= 20 chars.

        $this->userName = $userName;
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return $this->password;
    }

}