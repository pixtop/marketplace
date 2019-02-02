<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plateforme;
use AppBundle\Entity\Transaction;
use AppBundle\Form\PlateformeType;
use AppBundle\Service\HoteService;
use AppBundle\Service\PaymentService;
use AppBundle\Service\PlateformeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PlateformeController extends Controller
{
    /**
     * @Route("/plateforme", name="plateforme")
     */
    public function plateformeAction(Request $request, PaymentService $ps, PlateformeService $pfs, HoteService $hs)
    {
        if ($this->getUser()->getUsername() != 'plateforme' && !$this->getUser()->hasRole('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
        $hote = $hs->getHote();
        $pf = $pfs->getPlateforme();
        $info = $pf->isInfoHote();
        $form = $this->createForm(PlateformeType::class, $pf);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var Plateforme $data */
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();

            if (!$info && $data->isInfoHote()) {
                $t = new Transaction();
                $t->create(
                    $data->getAdmin(),
                    $hote->getResponsable(),
                    $hote->getCoutDonneePerso(),
                    "Achat des données personnelles par la plateforme");
                $entityManager->persist($t);
                $ps->updateSolde($t);
            }
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('plateforme');
        }
        return $this->render('AppBundle:Plateforme:index.html.twig', array(
            'plateforme' => $pf,
            'form' => $form->createView(),
            'hote' => $hote,
        ));
    }

}
