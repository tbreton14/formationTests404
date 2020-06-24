<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FoodRecord;
use AppBundle\Entity\User;
use AppBundle\Form\FoodType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;

class DiaryController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('security/login.html.twig');
        }

        return $this->render('diary/index.html.twig');
    }

    /**
     * @Route("/diary/list", name="diary")
     */
    public function listAction()
    {
        //dump($this->getUser()); die;

        $repository = $this->getDoctrine()->getRepository('AppBundle:FoodRecord');

        return $this->render(
            'diary/list.html.twig',
            [
                'records' => $repository->findAll(
                    [

                    ]
                )
            ]
        );
    }

    /**
     * @Route("/diary/add-new-record", name="add-new-record")
     */
    public function addRecordAction(Request $request)
    {
        $foodRecord = new FoodRecord();
        $form = $this->createForm(FoodType::class, $foodRecord);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($foodRecord);
            $em->flush();

            $this->addFlash('success', 'Une nouvelle entrée dans votre journal a bien été ajoutée.');

            return $this->redirectToRoute('add-new-record');
        }

        return $this->render('diary/addRecord.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/diary/edit-new-record/{id}", name="edit-new-record")
     */
    public function editRecordAction(Request $request, $id)
    {
        $foodRecord = $this->getDoctrine()->getRepository('AppBundle:FoodRecord')->find($id);
        $form = $this->createForm(FoodType::class, $foodRecord);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('diary');
        }

        return $this->render('diary/addRecord.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/diary/delete/{id}", name="delete-record")
     * fs
     */
    public function deleteRecordAction(Request $request, $id)
    {
        if (!$record = $this->getDoctrine()->getRepository('AppBundle:FoodRecord')->findOneById($id)) {
            $this->addFlash('danger', "L'entrée du journal n'existe pas.");

            return $this->redirectToRoute('diary');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($record);
        $em->flush();

        $this->addFlash('success', "L'entrée a bien été supprimée du journal.");


        return $this->redirectToRoute('diary');
    }
}
