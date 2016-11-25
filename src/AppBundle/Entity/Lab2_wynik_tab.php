<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Lab2_wynik_tab
 *
 * @ORM\Table(name="lab2_wynik_tab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab2_wynik_tabRepository")
 */
class Lab2_wynik_tab
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
     * @ORM\Column(name="dl1", type="decimal", precision=10, scale=2)
     */
    private $dl1;

    /**
     * @var string
     *
     * @ORM\Column(name="dl2", type="decimal", precision=10, scale=2)
     */
    private $dl2;

    /**
     * @var string
     *
     * @ORM\Column(name="sdl1", type="decimal", precision=10, scale=2)
     */
    private $sdl1;

    /**
     * @var string
     *
     * @ORM\Column(name="sdl2", type="decimal", precision=10, scale=2)
     */
    private $sdl2;

    /**
     * @var string
     *
     * @ORM\Column(name="dl3", type="decimal", precision=10, scale=2)
     */
    private $dl3;

    /**
     * @var string
     *
     * @ORM\Column(name="sdl3", type="decimal", precision=10, scale=2)
     */
    private $sdl3;

    /**
     * @var string
     *
     * @ORM\Column(name="sdl_sr", type="decimal", precision=10, scale=2)
     */
    private $sdlSr;

    /**
     * @var string
     *
     * @ORM\Column(name="E", type="decimal", precision=10, scale=2)
     */
    private $e;

    /**
     * @ManyToOne(targetEntity="Lab2_wynik", inversedBy="tab")
     * @JoinColumn(name="id_wynik", referencedColumnName="id")
     */
    private $wynik;


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
     * Set dl1
     *
     * @param string $dl1
     *
     * @return Lab2_wynik_tab
     */
    public function setDl1($dl1)
    {
        $this->dl1 = $dl1;

        return $this;
    }

    /**
     * Get dl1
     *
     * @return string
     */
    public function getDl1()
    {
        return $this->dl1;
    }

    /**
     * Set dl2
     *
     * @param string $dl2
     *
     * @return Lab2_wynik_tab
     */
    public function setDl2($dl2)
    {
        $this->dl2 = $dl2;

        return $this;
    }

    /**
     * Get dl2
     *
     * @return string
     */
    public function getDl2()
    {
        return $this->dl2;
    }

    /**
     * Set sdl1
     *
     * @param string $sdl1
     *
     * @return Lab2_wynik_tab
     */
    public function setSdl1($sdl1)
    {
        $this->sdl1 = $sdl1;

        return $this;
    }

    /**
     * Get sdl1
     *
     * @return string
     */
    public function getSdl1()
    {
        return $this->sdl1;
    }

    /**
     * Set sdl2
     *
     * @param string $sdl2
     *
     * @return Lab2_wynik_tab
     */
    public function setSdl2($sdl2)
    {
        $this->sdl2 = $sdl2;

        return $this;
    }

    /**
     * Get sdl2
     *
     * @return string
     */
    public function getSdl2()
    {
        return $this->sdl2;
    }

    /**
     * Set dl3
     *
     * @param string $dl3
     *
     * @return Lab2_wynik_tab
     */
    public function setDl3($dl3)
    {
        $this->dl3 = $dl3;

        return $this;
    }

    /**
     * Get dl3
     *
     * @return string
     */
    public function getDl3()
    {
        return $this->dl3;
    }

    /**
     * Set sdl3
     *
     * @param string $sdl3
     *
     * @return Lab2_wynik_tab
     */
    public function setSdl3($sdl3)
    {
        $this->sdl3 = $sdl3;

        return $this;
    }

    /**
     * Get sdl3
     *
     * @return string
     */
    public function getSdl3()
    {
        return $this->sdl3;
    }

    /**
     * Set sdlSr
     *
     * @param string $sdlSr
     *
     * @return Lab2_wynik_tab
     */
    public function setSdlSr($sdlSr)
    {
        $this->sdlSr = $sdlSr;

        return $this;
    }

    /**
     * Get sdlSr
     *
     * @return string
     */
    public function getSdlSr()
    {
        return $this->sdlSr;
    }

    /**
     * Set e
     *
     * @param string $e
     *
     * @return Lab2_wynik_tab
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

    /**
     * Set idOdczytu
     *
     * @param integer $idOdczyt
     *
     * @return Lab2_wynik_tab
     */
    public function setIdOdczyt($idOdczyt)
    {
        $this->idOdczyt = $idOdczyt;

        return $this;
    }

    /**
     * Get idOdczytu
     *
     * @return int
     */
    public function getIdOdczyt()
    {
        return $this->idOdczyt;
    }

    /**
     * Set idWyniku
     *
     * @param integer $idWynik
     *
     * @return Lab2_wynik_tab
     */
    public function setIdWynik($idWynik)
    {
        $this->idWynik = $idWynik;

        return $this;
    }

    /**
     * Get idWyniku
     *
     * @return int
     */
    public function getIdWynik()
    {
        return $this->idWynik;
    }
}

