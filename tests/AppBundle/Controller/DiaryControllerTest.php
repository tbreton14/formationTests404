<?php
/**
 * Created by PhpStorm.
 * User: tbreton
 * Date: 23/06/20
 * Time: 01:28
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;

class DiaryControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testHomepage()
    {
        $this->client->request('GET', '/');

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

//    public function testAddRecord()
//    {
//        $crawler = $this->client->request('GET', '/diary/add-new-record');
//
//        $form = $crawler->selectButton('Ajouter')->form();
//        $form['food[type]'] = 'Légume';
//        $form['food[entitled]'] = 'Poireaux';
//        $form['food[calories]'] = 80;
//        $crawler = $this->client->submit($form);
//
//        echo $this->client->getResponse()->getContent();
//    }

}