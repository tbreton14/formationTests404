<?php
/**
 * Created by PhpStorm.
 * User: tbreton
 * Date: 22/06/20
 * Time: 15:24
 */

namespace Tests\AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Security\GithubUserProvider;
use PHPUnit\Framework\TestCase;

class GithubUserProviderTest extends TestCase
{
    public function testLoadUserByUsernameReturningAUser() {
        $client = $this->getMockBuilder('GuzzleHttp\Client')->setMethods(['get'])
            ->disableOriginalConstructor()
            ->getMock();

        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();

        $response = $this->getMockBuilder("Psr\Http\Message\ResponseInterface")
            ->getMock();

        $client->expects($this->once())
            ->method('get')->willReturn($response);

        $streamedResponse = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->getMock();

        $response->expects($this->once())->method('getBody')->willReturn($streamedResponse);

        $userData = [
            'login' => "toto",
            'name' => "toto",
            'email' => "toto@test.fr",
            'avatar_url' => "test",
            'html_url' => "test",
        ];

        $serializer->method('deserialize')->willReturn($userData);

        $githubUserProvider = new GithubUserProvider($client, $serializer);
        $user = $githubUserProvider->loadUserByUsername('an-access-token');

        $expectedUser = new User($userData['login'], $userData['name'], $userData['email'], $userData['avatar_url'], $userData['html_url']);
        $this->assertEquals($expectedUser, $user);
        $this->assertEquals('AppBundle\Entity\User', get_class($user));



    }

}