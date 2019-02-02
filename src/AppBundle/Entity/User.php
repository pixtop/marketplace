<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="integer")
     */
    private $age = 18;

    /**
     * @var float
     *
     * @ORM\Column(name="solde", type="float")
     */
    private $solde = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="vendeur", type="boolean")
     */
    private $vendeur = false;

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return float
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param float $solde
     * @return float
     */
    public function addSolde($solde)
    {
        $this->solde += $solde;
        return $this->solde ;
    }

    /**
     * @param float $solde
     * @return float
     */
    public function rmSolde($solde)
    {
        $this->solde -= $solde;
        return $this->solde;
    }

    /**
     * @return float|int
     */
    public function resetSolde()
    {
        $this->solde = 0;
        return $this->solde;
    }

    /**
     * @return bool
     */
    public function isVendeur()
    {
        return $this->vendeur;
    }

    /**
     * @param bool $vendeur
     * @return User
     */
    public function setVendeur($vendeur)
    {
        $this->vendeur = $vendeur;
        return $this;
    }
}
