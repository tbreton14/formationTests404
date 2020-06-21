<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FoodRecord;
use AppBundle\Entity\RecipeRecord;
use AppBundle\Entity\User;
use AppBundle\Form\FoodType;
use AppBundle\Form\RecipeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;

class RecipeController extends Controller
{

    /**
     * @Route("/recipe/list", name="recipe")
     */
    public function listAction()
    {
        //dump($this->getUser()); die;

        $repository = $this->getDoctrine()->getRepository('AppBundle:RecipeRecord');

        return $this->render(
            'recipe/list.html.twig',
            [
                'records' => $repository->findAll(
                    [

                    ]
                )
            ]
        );
    }

    /**
     * @Route("/recipe/add-new-record", name="add-new-recipe")
     */
    public function addRecipeAction(Request $request)
    {
        $recipeRecord = new RecipeRecord();
        $form = $this->createForm(RecipeType::class, $recipeRecord);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipeRecord);
            $em->flush();

            $this->addFlash('success', 'Une nouvelle recette a bien été ajoutée.');

            return $this->redirectToRoute('add-new-recipe');
        }

        return $this->render('recipe/addRecipe.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/recipe/edit-record/{id}", name="edit-recipe")
     */
    public function editRecipeAction(Request $request,$id)
    {
        $recipeRecord = $this->getDoctrine()->getRepository('AppBundle:RecipeRecord')->find($id);
        $form = $this->createForm(RecipeType::class, $recipeRecord);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('recipe');
        }

        return $this->render('recipe/addRecipe.html.twig', ['form' => $form->createView()]);
    }

}
