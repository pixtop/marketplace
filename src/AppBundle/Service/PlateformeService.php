<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 11/12/18
 * Time: 19:10
 */

namespace AppBundle\Service;


use AppBundle\Entity\Plateforme;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PlateformeService
{
    /* @var Plateforme $plateforme */
    private $plateforme;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $p = $em->getRepository(Plateforme::class)->findAll();

        if (!$p) {
            $this->plateforme = new Plateforme();
            /* @var User $admin */
            $admin = $em->getRepository(User::class)->findOneBy(array('username' => 'plateforme'));
            $this->plateforme->setAdmin($admin);
        }
        else {
            $this->plateforme = $p[0];
        }
    }

    public function getPlateforme()
    {
        return $this->plateforme;
    }

    public function resetPlaforme()
    {
        $this->plateforme
            ->setCommissionVendeur(0)
            ->setCommissionAcheteur(0)
            ->setInscriptionVendeur(0)
            ->setInscriptionAcheteur(0)
            ->setTriChoix(0)
            ->setInfoHote(false);
    }
}