<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Lab2_pomiar
 *
 * @ORM\Table(name="lab2_pomiar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab2_pomiarRepository")
 */
class Lab2_pomiar
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
     * @ORM\Column(name="P01", type="decimal", precision=10, scale=2)
     */
    private $p01;

    /**
     * @var string
     *
     * @ORM\Column(name="S01", type="decimal", precision=10, scale=2)
     */
    private $s01;

    /**
     * @var string
     *
     * @ORM\Column(name="l01", type="decimal", precision=10, scale=2)
     */
    private $l01;

    /**
     * @var string
     *
     * @ORM\Column(name="P02", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $p02;

    /**
     * @var string
     *
     * @ORM\Column(name="S02", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $s02;

    /**
     * @var string
     *
     * @ORM\Column(name="l02", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $l02;

    /**
     * @OneToOne(targetEntity="Zespol", inversedBy="lab2Pomiar")
     * @JoinColumn(name="id_zespol", referencedColumnName="id")
     */
    private $zespol;

    public function getZespol()
    {
        return $this->zespol;
    }

    public function setZespol($zespol)
    {
        $this->zespol = $zespol;
    }/** @noinspection PhpUnusedPrivateFieldInspection */

    /**
     * @OneToMany(targetEntity="Lab2_pomiar_tab", mappedBy="pomiar")
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

    public function getP01()
    {
        return $this->p01;
    }

    public function setP01($p01)
    {
        $this->p01 = $p01;
    }

    public function getS01()
    {
        return $this->s01;
    }

    public function setS01($s01)
    {
        $this->s01 = $s01;
    }

    public function getL01()
    {
        return $this->l01;
    }

    public function setL01($l01)
    {
        $this->l01 = $l01;
    }

    public function getP02()
    {
        return $this->p02;
    }

    public function setP02($p02)
    {
        $this->p02 = $p02;
    }

    public function getS02()
    {
        return $this->s02;
    }

    public function setS02($s02)
    {
        $this->s02 = $s02;
    }

    public function getL02()
    {
        return $this->l02;
    }

    public function setL02($l02)
    {
        $this->l02 = $l02;
    }

  public function __toString() {
    return (string) $this->zespol;
  }
}



