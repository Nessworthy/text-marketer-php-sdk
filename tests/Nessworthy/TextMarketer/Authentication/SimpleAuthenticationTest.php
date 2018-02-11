<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Authentication;

use Nessworthy\TextMarketer\Authentication\InvalidAuthenticationException;
use Nessworthy\TextMarketer\Authentication\Simple;
use PHPUnit\Framework\TestCase;

class SimpleAuthenticationTest extends TestCase
{
    public function testAuthenticationReturnsSameCredentials()
    {
        $authentication = new Simple('sean.nessworthy', 'sean.the.sheep');

        $this->assertEquals('sean.nessworthy', $authentication->getUserName());
        $this->assertEquals('sean.the.sheep', $authentication->getPassword());
    }

    /**
     * @dataProvider fourCharacterStringsOrLessGenerator
     * @param string $user
     */
    public function testProvidingUserNameFourCharactersOrLessThrowsInvalidAuthenticationException(string $user)
    {
        $password = 'sean.the.sheep';
        $userLength = \strlen($user);

        $this->expectException(InvalidAuthenticationException::class);
        $this->expectExceptionCode(InvalidAuthenticationException::E_INVALID_USERNAME);
        $this->expectExceptionMessage('Your text marketer user name should be at least 5 characters, ' . $userLength . ' given.');

        new Simple($user, $password);
    }

    /**
     * @dataProvider fourCharacterStringsOrLessGenerator
     * @param string $password
     */
    public function testProvidingPasswordFourCharactersOrLessThrowsInvalidAuthenticationException(string $password)
    {
        $user = 'sean.the.sheep';
        $passwordLength = \strlen($password);

        $this->expectException(InvalidAuthenticationException::class);
        $this->expectExceptionCode(InvalidAuthenticationException::E_INVALID_PASSWORD);
        $this->expectExceptionMessage('Your text marketer password should be at least 5 characters, ' . $passwordLength . ' given.');

        new Simple($user, $password);
    }

    public function fourCharacterStringsOrLessGenerator()
    {
        return [
            [''],
            ['a'],
            ['ab'],
            ['abc'],
            ['abcd'],
        ];
    }
}