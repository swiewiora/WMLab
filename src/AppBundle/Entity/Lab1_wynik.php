<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Lab1_wynik
 *
 * @ORM\Table(name="lab1_wynik")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab1_wynikRepository")
 */
class Lab1_wynik
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
     * @ORM\Column(name="S0", type="decimal", precision=10, scale=2)
     */
    private $s0;

    /**
     * @var string
     *
     * @ORM\Column(name="Su", type="decimal", precision=10, scale=2)
     */
    private $su;

    /**
     * @var string
     *
     * @ORM\Column(name="A10", type="decimal", precision=10, scale=2)
     */
    private $a10;

    /**
     * @var string
     *
     * @ORM\Column(name="Z", type="decimal", precision=10, scale=2)
     */
    private $z;

    /**
     * @var string
     *
     * @ORM\Column(name="RH", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $rH;

    /**
     * @var string
     *
     * @ORM\Column(name="ReL", type="decimal", precision=10, scale=2)
     */
    private $reL;

    /**
     * @var string
     *
     * @ORM\Column(name="ReH", type="decimal", precision=10, scale=2)
     */
    private $reH;

    /**
     * @var string
     *
     * @ORM\Column(name="Rm", type="decimal", precision=10, scale=2)
     */
    private $rm;

    /**
     * @var string
     *
     * @ORM\Column(name="Ru", type="decimal", precision=10, scale=2)
     */
    private $ru;

    /**
     * @var string
     *
     * @ORM\Column(name="E", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $e;

    /**
     * @OneToOne(targetEntity="Zespol", inversedBy="lab1Wynik")
     * @JoinColumn(name="id_zespol", referencedColumnName="id")
     */
    private $zespol;

    /**
     * @OneToMany(targetEntity="Lab1_wynik_tab", mappedBy="wynik", cascade={"remove"})
     */
    private $tab;

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
     * Set s0
     *
     * @param string $s0
     *
     * @return Lab1_wynik
     */
    public function setS0($s0)
    {
        $this->s0 = $s0;

        return $this;
    }

    /**
     * Get s0
     *
     * @return string
     */
    public function getS0()
    {
        return $this->s0;
    }

    /**
     * Set su
     *
     * @param string $su
     *
     * @return Lab1_wynik
     */
    public function setSu($su)
    {
        $this->su = $su;

        return $this;
    }

    /**
     * Get su
     *
     * @return string
     */
    public function getSu()
    {
        return $this->su;
    }

    /**
     * Set a10
     *
     * @param string $a10
     *
     * @return Lab1_wynik
     */
    public function setA10($a10)
    {
        $this->a10 = $a10;

        return $this;
    }

    /**
     * Get a10
     *
     * @return string
     */
    public function getA10()
    {
        return $this->a10;
    }

    /**
     * Set z
     *
     * @param string $z
     *
     * @return Lab1_wynik
     */
    public function setZ($z)
    {
        $this->z = $z;

        return $this;
    }

    /**
     * Get z
     *
     * @return string
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * Set rH
     *
     * @param string $rH
     *
     * @return Lab1_wynik
     */
    public function setRH($rH)
    {
        $this->rH = $rH;

        return $this;
    }

    /**
     * Get rH
     *
     * @return string
     */
    public function getRH()
    {
        return $this->rH;
    }

    /**
     * Set reL
     *
     * @param string $reL
     *
     * @return Lab1_wynik
     */
    public function setReL($reL)
    {
        $this->reL = $reL;

        return $this;
    }

    /**
     * Get reL
     *
     * @return string
     */
    public function getReL()
    {
        return $this->reL;
    }

    /**
     * Set reH
     *
     * @param string $reH
     *
     * @return Lab1_wynik
     */
    public function setReH($reH)
    {
        $this->reH = $reH;

        return $this;
    }

    /**
     * Get reH
     *
     * @return string
     */
    public function getReH()
    {
        return $this->reH;
    }

    /**
     * Set rM
     *
     * @param string $rm
     *
     * @return Lab1_wynik
     */
    public function setRM($rm)
    {
        $this->rm = $rm;

        return $this;
    }

    /**
     * Get rM
     *
     * @return string
     */
    public function getRM()
    {
        return $this->rm;
    }

    /**
     * Set ru
     *
     * @param string $ru
     *
     * @return Lab1_wynik
     */
    public function setRu($ru)
    {
        $this->ru = $ru;

        return $this;
    }

    /**
     * Get ru
     *
     * @return string
     */
    public function getRu()
    {
        return $this->ru;
    }

    /**
     * Set e
     *
     * @param string $e
     *
     * @return Lab1_wynik
     */
    public function setE($e)
    {
        $this->e = $e;

        return $this;
    }

    /**
     * Get e
     *
     * @return string
     */
    public function getE()
    {
        return $this->e;
    }

    public function getZespol()
    {
        return $this->zespol;
    }

    public function setZespol($zespol)
    {
        $this->zespol = $zespol;
    }

  public function __toString() {
    return (string) $this->id;
  }

    public function getTab()
    {
        return $this->tab;
    }
}

