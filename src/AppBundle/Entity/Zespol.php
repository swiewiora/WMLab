<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use UserBundle\Entity\User;

/**
 * Zespol
 *
 * @ORM\Table(name="zespol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZespolRepository")
 */
class Zespol
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
     * @var int
     *
     * @ORM\Column(name="id_prowadzacego", type="integer")
     */
    private $idProwadzacego;

    /**
     * @OneToOne(targetEntity="Lab1_pomiar", mappedBy="zespol")
     */
    private $lab1Pomiar;

    /**
     * @OneToOne(targetEntity="Lab1_wynik", mappedBy="zespol")
     */
    private $lab1Wynik;

    /**
     * @OneToOne(targetEntity="Lab2_pomiar", mappedBy="zespol")
     */
    private $lab2Pomiar;

    /**
     * @OneToOne(targetEntity="Lab2_wynik", mappedBy="zespol")
     */
    private $lab2Wynik;

    /**
     * @var User
     * @OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="zespol")
     */
    private $user;

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
     * Set idProwadzacego
     *
     * @param integer $idProwadzacego
     *
     * @return Zespol
     */
    public function setIdProwadzacego($idProwadzacego)
    {
        $this->idProwadzacego = $idProwadzacego;

        return $this;
    }

    /**
     * Get idProwadzacego
     *
     * @return int
     */
    public function getIdProwadzacego()
    {
        return $this->idProwadzacego;
    }

    public function __toString() {
      return (string) $this->id;
    }
}
