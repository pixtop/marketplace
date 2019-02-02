<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 06/12/18
 * Time: 15:41
 */

namespace AppBundle\Service;


use AppBundle\Entity\Avis;

class AvisMoyenneService
{
    public function calculMoyenne($avis)
    {
        $sum = array_reduce($avis, function ($c, $i) {
            return $c + $i->getNote();
        },0);
        return round($sum/sizeof($avis));
    }
}