<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Lab2_wynik
 *
 * @ORM\Table(name="lab2_wynik")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab2_wynikRepository")
 */
class Lab2_wynik
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
     * @ORM\Column(name="F01", type="decimal", precision=10, scale=2)
     */
    private $f01;

    /**
     * @var string
     *
     * @ORM\Column(name="F02", type="decimal", precision=10, scale=2)
     */
    private $f02;

    /**
     * @var string
     *
     * @ORM\Column(name="Rc1", type="decimal", precision=10, scale=2)
     */
    private $rc1;

    /**
     * @var string
     *
     * @ORM\Column(name="Rc2", type="decimal", precision=10, scale=2)
     */
    private $rc2;

    /**
     * @var string
     *
     * @ORM\Column(name="Rc_sr", type="decimal", precision=10, scale=2)
     */
    private $rcSr;

    /**
     * @var string
     *
     * @ORM\Column(name="E_sr", type="decimal", precision=10, scale=2)
     */
    private $eSr;

    /**
     * @OneToOne(targetEntity="Zespol", inversedBy="lab2Wynik")
     * @JoinColumn(name="id_zespol", referencedColumnName="id")
     */
    private $zespol;

    /**
     * @OneToMany(targetEntity="Lab2_wynik_tab", mappedBy="wynik")
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
     * Set f01
     *
     * @param string $f01
     *
     * @return Lab2_wynik
     */
    public function setF01($f01)
    {
        $this->f01 = $f01;

        return $this;
    }

    /**
     * Get f01
     *
     * @return string
     */
    public function getF01()
    {
        return $this->f01;
    }

    /**
     * Set f02
     *
     * @param string $f02
     *
     * @return Lab2_wynik
     */
    public function setF02($f02)
    {
        $this->f02 = $f02;

        return $this;
    }

    /**
     * Get f02
     *
     * @return string
     */
    public function getF02()
    {
        return $this->f02;
    }

    /**
     * Set rc1
     *
     * @param string $rc1
     *
     * @return Lab2_wynik
     */
    public function setRc1($rc1)
    {
        $this->rc1 = $rc1;

        return $this;
    }

    /**
     * Get rc1
     *
     * @return string
     */
    public function getRc1()
    {
        return $this->rc1;
    }

    /**
     * Set rc2
     *
     * @param string $rc2
     *
     * @return Lab2_wynik
     */
    public function setRc2($rc2)
    {
        $this->rc2 = $rc2;

        return $this;
    }

    /**
     * Get rc2
     *
     * @return string
     */
    public function getRc2()
    {
        return $this->rc2;
    }

    /**
     * Set rcSr
     *
     * @param string $rcSr
     *
     * @return Lab2_wynik
     */
    public function setRcSr($rcSr)
    {
        $this->rcSr = $rcSr;

        return $this;
    }

    /**
     * Get rcSr
     *
     * @return string
     */
    public function getRcSr()
    {
        return $this->rcSr;
    }

    /**
     * Set eSr
     *
     * @param string $eSr
     *
     * @return Lab2_wynik
     */
    public function setESr($eSr)
    {
        $this->eSr = $eSr;

        return $this;
    }

    /**
     * Get eSr
     *
     * @return string
     */
    public function getESr()
    {
        return $this->eSr;
    }

    /**
     * Set idZespol
     *
     * @param integer $idZespol
     *
     * @return Lab2_wynik
     */
    public function setIdZespol($idZespol)
    {
        $this->idZespol = $idZespol;

        return $this;
    }

    /**
     * Get idZespol
     *
     * @return int
     */
    public function getIdZespol()
    {
        return $this->idZespol;
    }

  public function __toString() {
    return (string) $this->zespol;
  }
}

