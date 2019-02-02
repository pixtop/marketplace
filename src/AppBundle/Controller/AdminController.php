<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 04/01/19
 * Time: 11:52
 */

namespace AppBundle\Controller;

use AppBundle\Entity\InformationPersonnelle;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
use AppBundle\Service\HoteService;
use AppBundle\Service\IntegrateurService;
use AppBundle\Service\PlateformeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_page")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/clean", name="app_clean")
     */
    public function cleanAction(PlateformeService $ps, HoteService $hs, IntegrateurService $is)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(Produit::class)->findAll();
        $transactions = $em->getRepository(Transaction::class)->findAll();
        $infos = $em->getRepository(InformationPersonnelle::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();
        array_map(function ($u) {
            /* @var User $u */
            $u->resetSolde();
            return $u;
        }, $users);
        array_walk($produits, [$em,'remove']);
        array_walk($transactions, [$em, 'remove']);
        array_walk($infos, [$em, 'remove']);
        $ps->resetPlaforme();
        $hs->resetHote();
        $is->resetIntegrateur();
        $em->flush();

        return $this->redirectToRoute('admin_page');
    }

    /**
     * @Route("/reset", name="app_reset")
     */
    public function resetAction(PlateformeService $ps, HoteService $hs, IntegrateurService $is)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAcheteurVendeur();
        array_walk( $users, [$em, 'remove']);
        return $this->cleanAction($ps, $hs, $is);
    }
}
