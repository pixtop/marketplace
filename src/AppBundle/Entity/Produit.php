<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var float
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="cout", type="float")
     */
    private $cout;

    /**
     * @var int
     * @Assert\GreaterThanOrEqual(0)
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $vendeur;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="nImage", type="integer")
     */
    private $nImage;

    /**
     * @var int
     *
     * @ORM\Column(name="nbAchat", type="integer")
     */
    private $nbAchat = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="nbIntegrateur", type="integer")
     */
    private $nbIntegrateur = 0;

    /**
    * @ORM\OneToMany(targetEntity="Avis", mappedBy="produit", cascade={"remove"})
    */
    private $avis;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
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
     * Set prix
     *
     * @param float $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @return float
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * @param float $cout
     * @return Produit
     */
    public function setCout($cout)
    {
        $this->cout = $cout;
        return $this;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Produit
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Produit
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @return User
     */
    public function getVendeur()
    {
        return $this->vendeur;
    }

    /**
     * @param User $vendeur
     * @return Produit
     */
    public function setVendeur($vendeur)
    {
        $this->vendeur = $vendeur;
        return $this;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     * @return Produit
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return int
     */
    public function getNImage()
    {
        return $this->nImage;
    }

    /**
     * @param int $nImage
     * @return Produit
     */
    public function setNImage($nImage)
    {
        $this->nImage = $nImage;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbAchat()
    {
        return $this->nbAchat;
    }

    /**
     * @param int $nbAchat
     * @return Produit
     */
    public function setNbAchat($nbAchat)
    {
        $this->nbAchat = $nbAchat;
        return $this;
    }

    /**
     * @param int $nbAchat
     * @return Produit
     */
    public function addNbAchat($nbAchat)
    {
        $this->nbAchat += $nbAchat;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbIntegrateur()
    {
        return $this->nbIntegrateur;
    }

    /**
     * @param int $nbIntegrateur
     * @return Produit
     */
    public function setNbIntegrateur($nbIntegrateur)
    {
        $this->nbIntegrateur = $nbIntegrateur;
        return $this;
    }

    /**
     * @param int $nbIntegrateur
     * @return $this
     */
    public function addNbIntegrateur($nbIntegrateur)
    {
        $this->nbIntegrateur += $nbIntegrateur;
        return $this;
    }

    /**
     * @param int $nbIntegrateur
     * @return $this
     */
    public function rmNbIntegrateur($nbIntegrateur)
    {
        $this->nbIntegrateur -= $nbIntegrateur;
        return $this;
    }
}

