<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plateforme
 *
 * @ORM\Table(name="plateforme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlateformeRepository")
 */
class Plateforme
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     */
    private $admin;

    /**
     * @var float
     *
     * @ORM\Column(name="inscriptionAcheteur", type="float")
     */
    private $inscriptionAcheteur = 0;

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="commissionAcheteur", type="decimal", precision=3, scale=2)
     */
    private $commissionAcheteur = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="inscriptionVendeur", type="float")
     */
    private $inscriptionVendeur = 0;

    /**
     * @var float
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="commissionVendeur", type="decimal", precision=3, scale=2)
     */
    private $commissionVendeur = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="triChoix", type="integer")
     */
    private $triChoix = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="infoHote", type="boolean")
     */
    private $infoHote = false;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param User $admin
     * @return Plateforme
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    /**
     * Set inscriptionAcheteur
     *
     * @param float $inscriptionAcheteur
     *
     * @return Plateforme
     */
    public function setInscriptionAcheteur($inscriptionAcheteur)
    {
        $this->inscriptionAcheteur = $inscriptionAcheteur;

        return $this;
    }

    /**
     * Get inscriptionAcheteur
     *
     * @return float
     */
    public function getInscriptionAcheteur()
    {
        return $this->inscriptionAcheteur;
    }

    /**
     * Set commissionAcheteur
     *
     * @param float $commissionAcheteur
     *
     * @return Plateforme
     */
    public function setCommissionAcheteur($commissionAcheteur)
    {
        $this->commissionAcheteur = $commissionAcheteur;

        return $this;
    }

    /**
     * Get commissionAcheteur
     *
     * @return float
     */
    public function getCommissionAcheteur()
    {
        return $this->commissionAcheteur;
    }

    /**
     * Set inscriptionVendeur
     *
     * @param float $inscriptionVendeur
     *
     * @return Plateforme
     */
    public function setInscriptionVendeur($inscriptionVendeur)
    {
        $this->inscriptionVendeur = $inscriptionVendeur;

        return $this;
    }

    /**
     * Get inscriptionVendeur
     *
     * @return float
     */
    public function getInscriptionVendeur()
    {
        return $this->inscriptionVendeur;
    }

    /**
     * Set commissionVendeur
     *
     * @param float $commissionVendeur
     *
     * @return Plateforme
     */
    public function setCommissionVendeur($commissionVendeur)
    {
        $this->commissionVendeur = $commissionVendeur;

        return $this;
    }

    /**
     * Get commissionVendeur
     *
     * @return float
     */
    public function getCommissionVendeur()
    {
        return $this->commissionVendeur;
    }

    /**
     * Set triChoix
     *
     * @param integer $triChoix
     *
     * @return Plateforme
     */
    public function setTriChoix($triChoix)
    {
        $this->triChoix = $triChoix;

        return $this;
    }

    /**
     * Get triChoix
     *
     * @return int
     */
    public function getTriChoix()
    {
        return $this->triChoix;
    }

    /**
     * @return bool
     */
    public function isInfoHote()
    {
        return $this->infoHote;
    }

    /**
     * @param bool $infoHote
     * @return Plateforme
     */
    public function setInfoHote($infoHote)
    {
        $this->infoHote = $infoHote;
        return $this;
    }
}

