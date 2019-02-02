<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InformationPersonnelle;
use AppBundle\Form\InformationPersonnelleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class InformationPersonnelleController extends Controller
{
    /**
     * @Route("/preference", name="preference")
     */
    public function registerAction(Request $request)
    {
        if (!$info = $this->getDoctrine()->getRepository(InformationPersonnelle::class)->findOneBy(['utilisateur' => $this->getUser()])) {
            $info = new InformationPersonnelle();
        }
        $form = $this->createForm(InformationPersonnelleType::class, $info);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $info = $form->getData();
            $info->setUtilisateur($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($info);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:InformationPersonnelle:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
