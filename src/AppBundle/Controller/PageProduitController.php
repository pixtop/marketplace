<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Avis;
use AppBundle\Entity\Plateforme;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Transaction;
use AppBundle\Service\IntegrateurService;
use AppBundle\Service\PaymentService;
use AppBundle\Service\PlateformeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class PageProduitController extends Controller
{
    /**
     * @Route("/page/produit/{id}", name="page_produit")
     */
    public function indexAction(Request $request, Produit $produit, PaymentService $ps, PlateformeService $pfs, IntegrateurService $is)
    {
        /* @var Plateforme $plateforme */
        $plateforme = $pfs->getPlateforme();

        $integrateur = $is->getIntegrateur();

        $form = $this->createFormBuilder()
            ->add('qte',IntegerType::class, array(
                'label' => 'QTE: ',
                'data' => 1,
                'constraints' => array(
                    new GreaterThan(0),
                    new LessThanOrEqual($produit->getQuantite()))
            ))
            ->getForm();

        $avis = $this->getDoctrine()->getRepository(Avis::class)->findBy(array("produit" => $produit));
        $pavis = $this->get('knp_paginator')->paginate(
            array_reverse($avis),
            $request->query->get('page', 1),
            3
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && !$this->getUser()->isVendeur()) {
            $data = $form->getData();
            $produit
                ->setQuantite($produit->getQuantite() - $data['qte'])
                ->addNbAchat($data['qte']);
            if ($produit->getNbIntegrateur() > $data['qte']) {
                $produit->rmNbIntegrateur($data['qte']);
            }
            elseif ($produit->getNbIntegrateur() != 0) {
                $produit->setNbIntegrateur(0);
            }

            $t = new Transaction();
            $t->create(
                $this->getUser(),
                $produit->getVendeur(),
                $produit->getPrix()*$data['qte'],
                "Achat d'une quantité de ".$data['qte']." du produit ".$produit->getNom(),
                $plateforme->getCommissionAcheteur(),
                $plateforme->getCommissionVendeur());

            $ps->updateSolde($t, $plateforme->getAdmin());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($t);
            $entityManager->flush();

            return $this->redirectToRoute('avis_new', array(
                'id' => $produit->getId(),
            ));
        }

        return $this->render('AppBundle:PageProduit:index.html.twig', array(
            "form" => $form->createView(),
            "produit" => $produit,
            "nb_avis" => sizeof($avis),
            "plateforme" => $plateforme,
            "integrateur" => $integrateur,
            "avis" => $pavis,
            "tab" => $request->query->get('tab'),
        ));
    }

}
