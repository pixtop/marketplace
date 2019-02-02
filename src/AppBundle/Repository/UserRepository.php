<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 05/01/19
 * Time: 13:29
 */

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAcheteurVendeur()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM AppBundle:User u WHERE (u.username != :admin AND u.username != :integrateur
                AND u.username != :hote AND u.username != :plateforme)'
            )->setParameters(array(
                'admin' => 'admin',
                'integrateur' => 'integrateur',
                'hote' => 'hote',
                'plateforme' => 'plateforme'
            ))
            ->getResult();
    }
}