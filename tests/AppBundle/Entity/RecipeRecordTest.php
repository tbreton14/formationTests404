<?php
/**
 * Created by PhpStorm.
 * User: tbreton
 * Date: 22/06/20
 * Time: 10:18
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\FoodRecord;
use AppBundle\Entity\RecipeRecord;
use PHPUnit\Framework\TestCase;

class RecipeRecordTest extends TestCase
{
    public function testgetTotalCalories() {

        $recipeRecord = new RecipeRecord();
        $recipeRecord->setName("Ratatouille");

        $foodRecord1 = new FoodRecord("Tomate", "Légume", 25, 20);
        $foodRecord2 = new FoodRecord("Aubergine", "Légume", 50, 20);

        $recipeRecord->addFoodRecord($foodRecord1);
        $recipeRecord->addFoodRecord($foodRecord2);

        $this->assertSame(75, $recipeRecord->getTotalCalories());

    }

}