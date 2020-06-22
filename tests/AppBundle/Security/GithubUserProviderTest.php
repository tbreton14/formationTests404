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

    private $client;
    private $serializer;
    private $streamedResponse;
    private $response;

    public function setUp() :void
    {
        $this->client = $this->getMockBuilder('GuzzleHttp\Client')->setMethods(['get'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->response = $this->getMockBuilder("Psr\Http\Message\ResponseInterface")
            ->getMock();

        $this->streamedResponse = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->getMock();
    }

    public function tearDown(): void
    {
        $this->client = null;
        $this->serializer = null;
        $this->response = null;
        $this->streamedResponse = null;
    }


    public function testLoadUserByUsernameReturningAUser() {

        $this->client->expects($this->once())
            ->method('get')->willReturn($this->response);

        $this->streamedResponse = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->getMock();

        $this->response->expects($this->once())->method('getBody')->willReturn($this->streamedResponse);

        $userData = [
            'login' => "toto",
            'name' => "toto",
            'email' => "toto@test.fr",
            'avatar_url' => "test",
            'html_url' => "test",
        ];

        $this->serializer->method('deserialize')->willReturn($userData);

        $githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
        $user = $githubUserProvider->loadUserByUsername('an-access-token');

        $expectedUser = new User($userData['login'], $userData['name'], $userData['email'], $userData['avatar_url'], $userData['html_url']);
        $this->assertEquals($expectedUser, $user);
        $this->assertEquals('AppBundle\Entity\User', get_class($user));

    }

    public function testLoadUserByUsernameException() {

        $this->client->expects($this->once())
            ->method('get')->willReturn($this->response);

        $this->streamedResponse = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->getMock();

        $this->response->expects($this->once())->method('getBody')->willReturn($this->streamedResponse);

        $this->serializer->expects($this->once())->method('deserialize')->willReturn([]);
        $this->expectException('LogicException');

        $githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
        $githubUserProvider->loadUserByUsername('an-access-token');

    }

}