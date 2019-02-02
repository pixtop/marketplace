<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Avis;
use AppBundle\Entity\Produit;
use AppBundle\Service\AvisMoyenneService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Avi controller.
 *
 * @Route("avis")
 */
class AvisController extends Controller
{
    /**
     * Creates a new avis entity.
     *
     * @Route("/new/{id}", name="avis_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Produit $produit, AvisMoyenneService $ams)
    {
        $avis = new Avis();
        $form = $this->createForm('AppBundle\Form\AvisType', $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setProduit($produit);
            $avis->setAuteur($this->getUser());
            /* @var Avis $a */
            $a = $this->getDoctrine()->getRepository(Avis::class)->findBy(array('produit' => $produit));
            $a[] = $avis;
            $produit->setNote($ams->calculMoyenne($a));
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();

            return $this->redirectToRoute('page_produit', array('id' => $produit->getId()));
        }

        return $this->render('avis/new.html.twig', array(
            'avis' => $avis,
            'form' => $form->createView(),
        ));
    }
}
