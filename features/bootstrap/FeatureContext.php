<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Context\SnippetAcceptingContext;
use AppBundle\Entity\RecipeRecord;
use AppBundle\Entity\FoodRecord;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    private $recipe;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    private static $container;


    /**
     * @BeforeSuite
     */
    public static function bootstrapSymfony()
    {
        require_once __DIR__.'/../../app/autoload.php';
        require_once __DIR__.'/../../app/AppKernel.php';
        $kernel = new AppKernel('dev', true);
        $kernel->boot();
        self::$container = $kernel->getContainer();
    }


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->em = self::$container->get('doctrine')->getManager();
    }

    /**
     * @Given an empty recipe
     */
    public function anEmptyRecipe() {
        $this->recipe = new RecipeRecord();
    }

    /**
     * @When I create a recipe with two products
     */
    public function createARecipeWithTwoProduct() {
        $this->recipe->setName("Ratatouille v2");

        $foodRecord1 = new FoodRecord("Tomate", "Légume", 25, 20);
        $foodRecord2 = new FoodRecord("Aubergine", "Légume", 50, 20);

        $this->recipe->addFoodRecord($foodRecord1);
        $this->recipe->addFoodRecord($foodRecord2);

        $this->em->persist($this->recipe);
        $this->em->flush();
    }

    /**
     * @Then the recipe is created
     */
    public function theRecipeIsCreated() {
        echo "Recette créée";
    }

}
