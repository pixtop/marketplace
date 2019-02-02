<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Integrateur;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Transaction;
use AppBundle\Service\IntegrateurService;
use AppBundle\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 *
 * @Route("produit")
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="produit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('AppBundle:Produit')->findBy(array('vendeur' => $this->getUser()));

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, PaymentService $ps, IntegrateurService $is)
    {
        /* @var Integrateur $integrateur */
        $integrateur = $is->getIntegrateur();
        $produit = new Produit();

        $form = $this->createForm('AppBundle\Form\ProduitType', $produit, ['integrateur' => $integrateur]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user = $this->getUser()) {
                $produit->setVendeur($user);
            }

            $t = new Transaction();
            $t->create(
                $user,
                null,
                $produit->getCout()*$produit->getQuantite(),
                "Production d'une quantité de ".$produit->getQuantite()." du produit ".$produit->getNom());
            $ps->updateSolde($t);

            $em = $this->getDoctrine()->getManager();

            if ($integrateur->getActif() && $form->get('integrateur')->getData()) {
                $produit->setNbIntegrateur($produit->getQuantite());
                $t2 = new Transaction();
                $t2->create(
                    $produit->getVendeur(),
                    $integrateur->getResponsable(),
                    $integrateur->getPrix()*($produit->getQuantite()),
                    "Achat de l'intégrateur pour ".($produit->getQuantite())." produits"
                );
                $ps->updateSolde($t2);
                $em->persist($t2);
            }

            $em->persist($produit);
            $em->persist($t);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('id' => $produit->getId()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'integrateur' => $integrateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}", name="produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        if ($this->getUser() != $produit->getVendeur()) {
            throw $this->createAccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit, PaymentService $ps, IntegrateurService $is)
    {
        if ($this->getUser() != $produit->getVendeur()) {
            throw $this->createAccessDeniedException();
        }
        /* @var Integrateur $integrateur */
        $integrateur = $is->getIntegrateur();
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('AppBundle\Form\ProduitType', $produit, ['integrateur' => $integrateur]);
        $oldQte = $produit->getQuantite();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if ($produit->getQuantite()-$oldQte > 0) {
                $t = new Transaction();
                $t->create(
                    $produit->getVendeur(),
                    null,
                    $produit->getCout()*($produit->getQuantite()-$oldQte),
                    "Production d'une quantité de ".($produit->getQuantite()-$oldQte)." du produit ".$produit->getNom());
                $ps->updateSolde($t);
                $em->persist($t);

                if ($integrateur->getActif() && $editForm->get('integrateur')->getData()) {
                    $produit->addNbIntegrateur($produit->getQuantite()-$oldQte);
                    $t2 = new Transaction();
                    $t2->create(
                        $produit->getVendeur(),
                        $integrateur->getResponsable(),
                        $integrateur->getPrix()*($produit->getQuantite()-$oldQte),
                        "Achat de l'intégrateur pour ".($produit->getQuantite()-$oldQte)." produits"
                    );
                    $ps->updateSolde($t2);
                    $em->persist($t2);
                }
            }

            $em->flush();

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'integrateur' => $integrateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/{id}", name="produit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        if ($this->getUser() != $produit->getVendeur()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
