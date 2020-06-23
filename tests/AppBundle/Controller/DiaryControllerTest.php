<?php
/**
 * Created by PhpStorm.
 * User: tbreton
 * Date: 23/06/20
 * Time: 01:28
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiaryControllerTest extends WebTestCase
{

//    private $client;
//
//    public function setUp()
//    {
//        $this->client = static::createClient();
//    }
//
//    public function tearDown()
//    {
//        $this->client = null;
//    }

    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Bienvenue sur FoodDiary !")')->count()
        );
        //$this->assertSame(1, $crawler->filter('h1')->count());
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