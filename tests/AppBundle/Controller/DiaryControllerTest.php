<?php
/**
 * Created by PhpStorm.
 * User: tbreton
 * Date: 23/06/20
 * Time: 01:28
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\FoodRecord;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;
use Doctrine\Persistence\ObjectManager;

class DiaryControllerTest extends WebTestCase
{
    private $client = null;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testHomepage()
    {
        $this->client->request('GET', '/');

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testAddRecord()
    {
        $crawler = $this->client->request('GET', '/diary/add-new-record');

        $form = $crawler->selectButton('Ajouter')->form([]);

        $form['food[type]'] = 'Fruit';
        $form['food[entitled]'] = 'Poireaux';
        $form['food[calories]'] = 80;
        $form['food[teneurProteine]'] = 10;
        $crawler = $this->client->submit($form);

        $this->client->followRedirect();

        echo $this->client->getResponse()->getContent();
    }

    public function testList()
    {

        $crawler = $this->client->request('GET', '/diary/list');

        $link = $crawler->selectLink('Liste des ingrédients')->link();
        $crawler = $this->client->click($link);

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testEditRecord()
    {
        $foodRecords = $this->em->getRepository(FoodRecord::class)->findBy([],['id'=> 'DESC'],1);

        $crawler = $this->client->request('GET', '/diary/edit-new-record/'.$foodRecords[0]->getId());

        $form = $crawler->selectButton('Modifier')->form([]);

        $form['food[type]'] = 'Légume';
        $crawler = $this->client->submit($form);

        $this->client->followRedirect();

        echo $this->client->getResponse()->getContent();
    }

    public function testDeleteRecord()
    {
        $foodRecords = $this->em->getRepository(FoodRecord::class)->findBy([],['id'=> 'DESC'],1);

        $this->client->request('GET', '/diary/delete/'.$foodRecords[0]->getId());

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

    }

    public function testDeleteRecordIdNotExist()
    {

        $this->client->request('GET', '/diary/delete/0');

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

}