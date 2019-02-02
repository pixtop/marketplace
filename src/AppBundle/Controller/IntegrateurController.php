<?php

namespace AppBundle\Controller;

use AppBundle\Form\IntegrateurType;
use AppBundle\Service\IntegrateurService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IntegrateurController extends Controller
{
    /**
     * @Route("/integrateur", name="integrateur")
     */
    public function indexAction(Request $request, IntegrateurService $is)
    {
        if ($this->getUser()->getUsername() != 'integrateur' && !$this->getUser()->hasRole('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $integrateur = $is->getIntegrateur();
        $form = $this->createForm(IntegrateurType::class, $integrateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($integrateur);
            $entityManager->flush();

            return $this->redirectToRoute('integrateur');
        }

        return $this->render('AppBundle:Integrateur:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
