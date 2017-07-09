<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;

use AppBundle\Entity\Bonobo;
use AppBundle\Entity\Family;

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
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }
        $bonobo = new Bonobo();
        $form = $this->createForm('AppBundle\Form\BonoboType', $bonobo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $bonobo->getAccount()->setEnabled(1);
            $bonobo->getAccount()->addRole("ROLE_USER");
	        $bonobo->getAccount()->setBonobo($bonobo);
            $bonobo->getAccount()->setInscriptionDate(new \DateTime("now", new \DateTimeZone("Africa/Tunis")));

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

    /**
     * Action pour modifier les informations du Bonobo connecté
     *
     * @Route("/moncompte/modifier", name="bonobo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $bonobo = $this->getUser()->getBonobo();
        $form = $this->createForm('AppBundle\Form\BonoboType', $bonobo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bonobo);
            $em->flush();

            return $this->redirectToRoute('bonobo_show', array('id' => $this->getUser()->getBonobo()->getId()));
        }

        return $this->render('bonobo/edit.html.twig', array(
            'bonobo' => $bonobo,
            'form' => $form->createView(),
        ));

    }

    /**
     * Afficher les informations d'un Bonobo
     *
     * @Route("/bonobo/{id}", name="bonobo_show")
     * @Method("GET")
     */
    public function showAction(Bonobo $bonobo)
    {
        return $this->render('bonobo/show.html.twig', array(
            'bonobo' => $bonobo,
        ));
    }

    /**
     * Action pour qu'un Bonobo ajout un ami
     *
     * @Route("/amis/ajout", name="add_friend")
     * @Method({"GET", "POST"})
     */
    public function newFriendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bonobos = $em->getRepository('AppBundle:Bonobo')->findAll();

        $bonobo = new Bonobo();
        $currentBonobo = $this->getUser()->getBonobo();
        $form = $this->createForm('AppBundle\Form\FriendType', $bonobo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->addFriendAction($bonobo);
        }

        return $this->render('bonobo/add.html.twig', array(
            'adding' => 'ami',
            'bonobos' => $bonobos,
            'form' => $form->createView(),
        ));
    }

        /**
         * Action pour qu'un Bonobo ajout un ami depuis la liste des bonobo du site
         *
         * @Route("/ajouterAmi/{id}", name="add_to_friends")
         * @Method("GET")
         */
        public function addFriendAction(Bonobo $bonobo)
        {
            $em = $this->getDoctrine()->getManager();
            $currentBonobo = $this->getUser()->getBonobo();

            $currentBonobo->addMyFriend($bonobo);
            $bonobo->addFriendsWithMe($currentBonobo);

            $em->persist($bonobo);
            $em->persist($currentBonobo);
            $em->flush();

            $this->addFlash('friend-add-success','Ami ajouté avec succée');
            return $this->redirectToRoute('bonobo_show', array('id' => $currentBonobo->getId()));
        }

    /**
     * Action pour qu'un Bonobo ajout un membre de famille
     *
     * @Route("/famille/ajout", name="add_family")
     * @Method({"GET", "POST"})
     */
    public function newFamilyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bonobos = $em->getRepository('AppBundle:Bonobo')->findAll();

        $bonobo = new Bonobo();
        $currentBonobo = $this->getUser()->getBonobo();
        $form = $this->createForm('AppBundle\Form\FamilyMemberType', $bonobo);
        $familyData = new Family();
        $familyForm = $this->createForm('AppBundle\Form\FamilyType', $familyData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relation = $form['relation']->getData()['relation'];

            return $this->addFamilyAction($bonobo, $relation);
        }

        return $this->render('bonobo/add.html.twig', array(
            'adding' => 'membre de famille',
            'bonobos' => $bonobos,
            'form' => $form->createView(),
            'familyForm' => $familyForm->createView(),
        ));
    }

    /**
     * Action pour qu'un Bonobo ajout un membre de famille depuis la liste des bonobo du site
     *
     * @Route("/ajouterMembreFamille/{id}/{relation}", name="add_family_member")
     * @Method("GET")
     */
    public function addFamilyAction(Bonobo $bonobo, $relation)
    {
        $em = $this->getDoctrine()->getManager();
        $currentBonobo = $this->getUser()->getBonobo();

        $myFamily = new Family();
        $familyWithMe = new Family();

        $myFamily->setBonobo($currentBonobo);
        $myFamily->setFamilyMember($bonobo);
        $myFamily->setRelation($relation);

        $currentBonobo->addMyFamily($myFamily);

        $em->persist($myFamily);
        $em->persist($bonobo);
        $em->persist($currentBonobo);
        $em->flush();

        $this->addFlash('family-add-success', $relation . ' ajouté avec succée');
        return $this->redirectToRoute('bonobo_show', array('id' => $currentBonobo->getId()));
    }

    /**
     * Afficher la liste des amis du Bonobo connecté
     *
     * @Route("/mesamis", name="my_friends")
     * @Method("GET")
     */
    public function myFriendsAction()
    {
        return $this->render('bonobo/my_friends.html.twig');
    }

    /**
     * Afficher les membres de la famille du Bonobo connecté
     *
     * @Route("/mafamille", name="my_family")
     * @Method("GET")
     */
    public function myFamilyAction()
    {
        return $this->render('bonobo/my_family.html.twig');
    }

    /**
     * supprimer un ami du Bonobo connecté
     *
     * @Route("/supprimerAmi/{id}", name="remove_friend")
     * @Method("GET")
     */
    public function deleteFriendAction(Bonobo $bonobo)
    {
        $currentBonobo = $this->getUser()->getBonobo();

        $currentBonobo->removeMyFriend($bonobo);
        $currentBonobo->removeFriendsWithMe($bonobo);
        $bonobo->removeFriendsWithMe($currentBonobo);
        $bonobo->removeMyFriend($currentBonobo);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentBonobo);
        $em->persist($bonobo);
        $em->flush();

        $this->addFlash('friend-remove-success','Ami supprimé avec succée');
        return $this->redirectToRoute('my_friends');

    }

        /**
         * supprimer un ami du Bonobo connecté
         *
         * @Route("/supprimerMembreFamille/{id}", name="remove_family_member")
         * @Method("GET")
         */
        public function deleteFamilyMemberAction(Bonobo $bonobo)
        {
            $this->addFlash('family-remove-success','Membre de famille supprimé avec succée');

            $currentBonobo = $this->getUser()->getBonobo();

            $em = $this->getDoctrine()->getManager();

            $family = $currentBonobo->removeFromFamily($bonobo);
            if ($family) {
                $em->remove($family);
            }

            $family = $bonobo->removeFromFamily($currentBonobo);
            if ($family) {
                $em->remove($family);
            }

            $em->persist($currentBonobo);
            $em->persist($bonobo);
            $em->flush();

            return $this->redirectToRoute('my_family');

        }
}
