<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InformationPersonnelle
 *
 * @ORM\Table(name="information_personnelle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InformationPersonnelleRepository")
 */
class InformationPersonnelle
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
     * @ORM\Column(name="descriptionProjet", type="string", length=255)
     */
    private $descriptionProjet;

    /**
     * @var float
     *
     * @ORM\Column(name="budgetOrdinateur", type="float")
     */
    private $budgetOrdinateur = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="budgetLivre", type="float")
     */
    private $budgetLivre = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="budgetObjetCourant", type="float")
     */
    private $budgetObjetCourant = 0;


    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User")
     */
    private $utilisateur;

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
     * Set descriptionProjet
     *
     * @param string $descriptionProjet
     *
     * @return InformationPersonnelle
     */
    public function setDescriptionProjet($descriptionProjet)
    {
        $this->descriptionProjet = $descriptionProjet;

        return $this;
    }

    /**
     * Get descriptionProjet
     *
     * @return string
     */
    public function getDescriptionProjet()
    {
        return $this->descriptionProjet;
    }

    /**
     * Set budgetOrdinateur
     *
     * @param float $budgetOrdinateur
     *
     * @return InformationPersonnelle
     */
    public function setBudgetOrdinateur($budgetOrdinateur)
    {
        $this->budgetOrdinateur = $budgetOrdinateur;

        return $this;
    }

    /**
     * Get budgetOrdinateur
     *
     * @return float
     */
    public function getBudgetOrdinateur()
    {
        return $this->budgetOrdinateur;
    }

    /**
     * Set budgetLivre
     *
     * @param float $budgetLivre
     *
     * @return InformationPersonnelle
     */
    public function setBudgetLivre($budgetLivre)
    {
        $this->budgetLivre = $budgetLivre;

        return $this;
    }

    /**
     * Get budgetLivre
     *
     * @return float
     */
    public function getBudgetLivre()
    {
        return $this->budgetLivre;
    }

    /**
     * Set budgetObjetCourant
     *
     * @param float $budgetObjetCourant
     *
     * @return InformationPersonnelle
     */
    public function setBudgetObjetCourant($budgetObjetCourant)
    {
        $this->budgetObjetCourant = $budgetObjetCourant;

        return $this;
    }

    /**
     * Get budgetObjetCourant
     *
     * @return float
     */
    public function getBudgetObjetCourant()
    {
        return $this->budgetObjetCourant;
    }

    /**
     * @return User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param User $utilisateur
     * @return InformationPersonnelle
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}

