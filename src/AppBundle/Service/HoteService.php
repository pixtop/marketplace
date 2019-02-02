<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 13/12/18
 * Time: 12:32
 */

namespace AppBundle\Service;


use AppBundle\Entity\Hote;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class HoteService
{
    /**
     * @var Hote
     */
    private $hote;

    public function __construct(EntityManagerInterface $em)
    {
        $h = $em->getRepository(Hote::class)->findAll();

        if (!$h) {
            $this->hote = new Hote();
            /* @var User $responsable */
            $responsable = $em->getRepository(User::class)->findOneBy(array('username' => 'hote'));
            $this->hote->setResponsable($responsable);
        }
        else {
            $this->hote = $h[0];
        }
    }

    public function getHote()
    {
        return $this->hote;
    }

    public function resetHote()
    {
        $this->hote
            ->setCoutDonneePerso(0);
    }
}