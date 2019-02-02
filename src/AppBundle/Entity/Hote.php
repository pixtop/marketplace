<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hote
 *
 * @ORM\Table(name="hote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HoteRepository")
 */
class Hote
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
     * @var float
     *
     * @ORM\Column(name="coutDonneePerso", type="float")
     */
    private $coutDonneePerso = 0;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User")
     */
    private $responsable;

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
     * Set coutDonneePerso
     *
     * @param float $coutDonneePerso
     *
     * @return Hote
     */
    public function setCoutDonneePerso($coutDonneePerso)
    {
        $this->coutDonneePerso = $coutDonneePerso;

        return $this;
    }

    /**
     * Get coutDonneePerso
     *
     * @return float
     */
    public function getCoutDonneePerso()
    {
        return $this->coutDonneePerso;
    }

    /**
     * @return User
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param User $responsable
     * @return Hote
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
        return $this;
    }
}

