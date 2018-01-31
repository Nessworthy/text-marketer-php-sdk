<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Authentication;

use Nessworthy\TextMarketer\Authentication\InvalidAuthenticationException;
use Nessworthy\TextMarketer\Authentication\SimpleAuthentication;
use PHPUnit\Framework\TestCase;

class SimpleAuthenticationTest extends TestCase
{
    public function testAuthenticationReturnsSameCredentials()
    {
        $authentication = new SimpleAuthentication('sean.nessworthy', 'sean.the.sheep');

        $this->assertEquals('sean.nessworthy', $authentication->getUserName());
        $this->assertEquals('sean.the.sheep', $authentication->getPassword());
    }

    /**
     * @dataProvider fiveCharacterStringsOrLessGenerator
     * @param string $user
     */
    public function testProvidingUserNameFiveCharactersOrLessThrowsInvalidAuthenticationException(string $user)
    {
        $password = 'sean.the.sheep';
        $userLength = \strlen($user);

        $this->expectException(InvalidAuthenticationException::class);
        $this->expectExceptionCode(InvalidAuthenticationException::E_INVALID_USERNAME);
        $this->expectExceptionMessage('Your text marketer user name should be at least 6 characters, ' . $userLength . ' given.');

        new SimpleAuthentication($user, $password);
    }

    /**
     * @dataProvider fiveCharacterStringsOrLessGenerator
     * @param string $password
     */
    public function testProvidingPasswordFiveCharactersOrLessThrowsInvalidAuthenticationException(string $password)
    {
        $user = 'sean.the.sheep';
        $passwordLength = \strlen($password);

        $this->expectException(InvalidAuthenticationException::class);
        $this->expectExceptionCode(InvalidAuthenticationException::E_INVALID_PASSWORD);
        $this->expectExceptionMessage('Your text marketer password should be at least 6 characters, ' . $passwordLength . ' given.');

        new SimpleAuthentication($user, $password);
    }

    public function fiveCharacterStringsOrLessGenerator()
    {
        return [
            [''],
            ['a'],
            ['ab'],
            ['abc'],
            ['abcd'],
            ['abcde'],
        ];
    }
}