<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InformationPersonnelle;
use AppBundle\Service\HoteService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class HoteController extends Controller
{
    /**
     * @Route("/hote", name="hote")
     */
    public function indexAction(Request $request, HoteService $hs)
    {
        if ($this->getUser()->getUsername() != 'hote' && !$this->getUser()->hasRole('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $hote = $hs->getHote();
        $infos = $this->getDoctrine()->getRepository(InformationPersonnelle::class)->findAll();

        $form = $this
                    ->createFormBuilder($hote)
                    ->add('coutDonneePerso', MoneyType::class, array(
                        'label' => 'Prix de vente du jeu de données personnelles total',
                        'constraints' => array(new GreaterThanOrEqual(0))
                    ))
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('hote');
        }

        return $this->render('AppBundle:Hote:index.html.twig', array(
            'form' => $form->createView(),
            'infos' => $infos,
        ));
    }

}
