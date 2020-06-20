<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class RecipeRecord
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Nom de la recette")
     */
    private $name;

    /**
     * @var Category Catégorie de la société
     *
     * @ORM\ManyToOne(targetEntity="FoodRecord", inversedBy="recipeRecord")
     */
    private $foodRecords;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Category
     */
    public function getFoodRecords()
    {
        return $this->foodRecords;
    }

    /**
     * @param Category $foodRecords
     */
    public function setFoodRecords($foodRecords)
    {
        $this->foodRecords = $foodRecords;
    }





}