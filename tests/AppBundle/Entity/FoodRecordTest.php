<?php
/**
 * Created by PhpStorm.
 * User: tbreton
 * Date: 22/06/20
 * Time: 10:18
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\FoodRecord;
use PHPUnit\Framework\TestCase;

class FoodRecordTest extends TestCase
{
    public function testGetPercentProteineByCal() {

        $foodRecord = new FoodRecord();
        $foodRecord->setEntitled("Tomate");
        $foodRecord->setType("Légume");
        $foodRecord->setCalories("25");
        $foodRecord->setTeneurProteine("10");

        $this->assertSame(164, $foodRecord->getPercentProteineByCal());

    }

}