<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 26/11/18
 * Time: 11:12
 */

namespace AppBundle\Service;


use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;

class PaymentService
{
    /**
     * @param Transaction $t
     * @param User|null $admin
     * @return User|null
     */
    public function updateSolde(Transaction $t, User $admin = null)
    {
        $t->getEmissaire()->rmSolde($t->getSomme()*(1+$t->getCommissionAcheteur()));
        if ($d = $t->getDestinataire()) {
            /* @var $d User */
            $d->addSolde($t->getSomme()*(1-$t->getCommissionVendeur()));
        }
        if ($admin) {
            $admin->addSolde($t->getSomme()*($t->getCommissionAcheteur()+$t->getCommissionVendeur()));
        }
    }
}