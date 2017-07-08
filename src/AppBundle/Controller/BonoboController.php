<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bonobo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * Bonobo controller.
 */
class BonoboController extends Controller
{

    /**
     * Action pour l'inscription d'un nouveau Bonobo
     *
     * @Route("/inscription", name="inscription")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bonobo = new Bonobo();
        $form = $this->createForm('AppBundle\Form\BonoboType', $bonobo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $bonobo->getAccount()->setEnabled(1);
            $bonobo->getAccount()->addRole("ROLE_USER");
	    $bonobo->getAccount()->setBonobo($bonobo);
            $bonobo->getCompte()->setDateInscription(new \DateTime("now", new \DateTimeZone("Africa/Tunis")));

            $em->persist($bonobo->getAccount());
            $em->persist($bonobo);
            $em->flush();

            $dispatcher = $this->get('event_dispatcher');
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            $userManager->updateUser($bonobo->getAccount());
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED
                            , new FilterUserResponseEvent($bonobo->getAccount(), $request, $response));

            return $response;
        }

        return $this->render('bonobo/new.html.twig', array(
            'bonobo' => $bonobo,
            'form' => $form->createView(),
        ));
    }

}
