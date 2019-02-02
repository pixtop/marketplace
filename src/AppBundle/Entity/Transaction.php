<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 */
class Transaction
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $emissaire;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $destinataire;

    /**
     * @var float
     *
     * @ORM\Column(name="somme", type="float")
     */
    private $somme;

    /**
     * @var float
     *
     * @ORM\Column(name="commissionAcheteur", type="decimal", precision=3, scale=2)
     */
    private $commissionAcheteur;

    /**
     * @var float
     *
     * @ORM\Column(name="commissionVendeur", type="decimal", precision=3, scale=2)
     */
    private $commissionVendeur;

    public function create(User $e, $d, $s, $txt = "", $ca = 0., $cv = 0.)
    {
        $this->emissaire = $e;
        $this->destinataire = $d;
        $this->somme = $s;
        $this->description = $txt;
        $this->commissionAcheteur = $ca;
        $this->commissionVendeur = $cv;
    }

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
     * Set description
     *
     * @param string $description
     *
     * @return Transaction
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set emissaire
     *
     * @param User $emissaire
     *
     * @return Transaction
     */
    public function setEmissaire($emissaire)
    {
        $this->emissaire = $emissaire;

        return $this;
    }

    /**
     * Get emissaire
     *
     * @return User
     */
    public function getEmissaire()
    {
        return $this->emissaire;
    }

    /**
     * Set destinataire
     *
     * @param User $destinataire
     *
     * @return Transaction
     */
    public function setDestinataire($destinataire)
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    /**
     * Get destinataire
     *
     * @return User
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * Set somme
     *
     * @param float $somme
     *
     * @return Transaction
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme
     *
     * @return float
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * @return float
     */
    public function getCommissionAcheteur()
    {
        return $this->commissionAcheteur;
    }

    /**
     * @param float $commissionAcheteur
     * @return Transaction
     */
    public function setCommissionAcheteur($commissionAcheteur)
    {
        $this->commissionAcheteur = $commissionAcheteur;
        return $this;
    }

    /**
     * @return float
     */
    public function getCommissionVendeur()
    {
        return $this->commissionVendeur;
    }

    /**
     * @param float $commissionVendeur
     * @return Transaction
     */
    public function setCommissionVendeur($commissionVendeur)
    {
        $this->commissionVendeur = $commissionVendeur;
        return $this;
    }
}

