<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class FoodRecord
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $recordedAt;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ingrédient")
     */
    private $entitled;

    /**
     * @ORM\Column(type="text")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer un nombre de calories")
     * @Assert\Range(min=0, minMessage="Les calories ne peuvent pas être négatives.")
     */
    private $calories;

    /**
     * @ORM\Column(type="float")
     */
    private $teneurProteine;

    /**
     *
     * @ORM\OneToMany(targetEntity="RecipeRecord", mappedBy="foodRecords")
     */
    private $recipeRecord;


    public function getPercentProteineByCal() {

        $kcalProteine = 4.1;


        if($this->type == "Viande") {
            $kcalProteine = 12.3;
        }

        $teneurProteineByKcal = $kcalProteine * $this->teneurProteine;

        return ($teneurProteineByKcal / $this->calories) * 100;
    }

    public function __construct()
    {
        $this->recordedAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->entitled;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getRecordedAt()
    {
        return $this->recordedAt;
    }

    public function setRecordedAt(\Datetime $recordedAt)
    {
        $this->recordedAt = $recordedAt;
    }

    public function getCalories()
    {
        return $this->calories;
    }

    public function setCalories($calories)
    {
        $this->calories = $calories;
    }

    public function getEntitled()
    {
        return $this->entitled;
    }

    public function setEntitled($entitled)
    {
        $this->entitled = $entitled;
    }

    /**
     * @return mixed
     */
    public function getTeneurProteine()
    {
        return $this->teneurProteine;
    }

    /**
     * @param mixed $teneurProteine
     */
    public function setTeneurProteine($teneurProteine)
    {
        $this->teneurProteine = $teneurProteine;
    }

    /**
     * @return mixed
     */
    public function getRecipeRecord()
    {
        return $this->recipeRecord;
    }

    /**
     * @param mixed $recipeRecord
     */
    public function setRecipeRecord($recipeRecord)
    {
        $this->recipeRecord = $recipeRecord;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }





}