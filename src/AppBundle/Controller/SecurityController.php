<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->render(
            'securit/login.html.twig',
            [
                'csrf_token' => $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            ]
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction(Request $request)
    {
        

    }

    /**
     * @Route("/auth", name="github_redirect_url")
     */
    public function adminAuthAction()
    {
        // To avoid the ?code= url. Can be done with Javascript.
        return $this->redirectToRoute('diary');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }
}