<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InformationPersonnelle;
use AppBundle\Entity\Plateforme;
use AppBundle\Entity\Produit;
use AppBundle\Service\PlateformeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    /**
     * List all products in a category.
     *
     * @Route("/categorie/{categorie}", name="categorie")
     */
    public function showAction(Request $request, PlateformeService $pfs, $categorie)
    {
        /* @var Plateforme $plateforme*/
        $plateforme = $pfs->getPlateforme();
        $info = $this->getDoctrine()->getRepository(InformationPersonnelle::class)->findOneBy(['utilisateur' => $this->getUser()]);
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findByChoice($plateforme->getTriChoix(), $categorie, $info, $plateforme->getCommissionAcheteur());
        $pProduits = $this->get('knp_paginator')->paginate(
            $produits,
            $request->query->get('page', 1),
            9
        );

        return $this->render('AppBundle:Categorie:show.html.twig', array(
            "produits" => $pProduits,
            "plateforme" => $plateforme,
        ));
    }
}
