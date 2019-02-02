<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 12/12/18
 * Time: 13:23
 */

namespace AppBundle\Service;


use AppBundle\Entity\Integrateur;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class IntegrateurService
{

    /**
     * @var Integrateur
     */
    private $integrateur;

    public function __construct(EntityManagerInterface $em)
    {
        $i = $em->getRepository(Integrateur::class)->findAll();

        if (!$i) {
            $this->integrateur = new Integrateur();
            /* @var User $responsable */
            $responsable = $em->getRepository(User::class)->findOneBy(array('username' => 'integrateur'));
            $this->integrateur->setResponsable($responsable);
        }
        else {
            $this->integrateur = $i[0];
        }
    }

    public function getIntegrateur()
    {
        return $this->integrateur;
    }

    public function resetIntegrateur()
    {
        $this->integrateur
            ->setActif(false)
            ->setNom("")
            ->setPrix(0);
    }
}