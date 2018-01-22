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
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", nullable=true)
     */
    private $nazwa;

    /**
     * @OneToOne(targetEntity="Lab1_pomiar", mappedBy="zespol", cascade={"remove"})
     */
    private $lab1Pomiar;

    /**
     * @OneToOne(targetEntity="Lab1_wynik", mappedBy="zespol", cascade={"remove"})
     */
    private $lab1Wynik;

    /**
     * @OneToOne(targetEntity="Lab2_pomiar", mappedBy="zespol"), cascade={"remove"}
     */
    private $lab2Pomiar;

    /**
     * @OneToOne(targetEntity="Lab2_wynik", mappedBy="zespol", cascade={"remove"})
     */
    private $lab2Wynik;

    /*
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

    public function getNazwa()
    {
        return $this->nazwa;
    }

    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }

    public function getLab1Pomiar()
    {
        return $this->lab1Pomiar;
    }

    public function getLab1Wynik()
    {
        return $this->lab1Wynik;
    }

    public function getLab2Pomiar()
    {
        return $this->lab2Pomiar;
    }

    public function getLab2Wynik()
    {
        return $this->lab2Wynik;
    }

    public function getUser()
    {
        return $this->user;
    }



    public function __toString() {
        if($this->nazwa)
            return $this->nazwa;
        else
            return (string) $this->id;
    }
}
