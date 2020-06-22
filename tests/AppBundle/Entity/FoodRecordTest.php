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
    public function testgetPercentProteineByCal() {

        $foodRecord = new FoodRecord("Pomme de terre", "Légume", 25, 20);

        $this->assertSame(floatval(328), $foodRecord->getPercentProteineByCal());

    }

}