<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 11/12/18
 * Time: 21:27
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\Plateforme;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
use AppBundle\Service\PaymentService;
use AppBundle\Service\PlateformeService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationListener implements EventSubscriberInterface
{

    private $ps;

    private $em;

    private $router;

    private $pfs;

    public function __construct(UrlGeneratorInterface $router, EntityManagerInterface $em, PaymentService $ps, PlateformeService $pfs)
    {
        $this->em = $em;
        $this->ps = $ps;
        $this->router = $router;
        $this->pfs = $pfs;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
          FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        /* @var User $user */
        $user = $event->getForm()->getData();
        /* @var Plateforme $plateforme */
        $plateforme = $this->pfs->getPlateforme();
        if ($user->isVendeur()) {
            $user->addRole('ROLE_VENDOR');
            $si = $plateforme->getInscriptionVendeur();
            $txt = "Inscription du vendeur ".$user->getUsername();
        }
        else {
            $si = $plateforme->getInscriptionAcheteur();
            $txt = "Inscription de l'acheteur ".$user->getUsername();
        }
        $t = new Transaction;
        $t->create($user, $plateforme->getAdmin(), $si, $txt);
        $this->ps->updateSolde($t);
        $this->em->persist($t);

        $event->setResponse(new RedirectResponse($this->router->generate('homepage')));
    }
}