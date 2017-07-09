<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * Action pour intercepter la route register défini par FOSUserBundle et la remplace par la page d'inscription qu'on a créer
     *
     * @Route("/register/", name="register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        return $this->redirectToRoute('inscription');
    }

}
