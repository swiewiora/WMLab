<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Lab1_wynik_tab
 *
 * @ORM\Table(name="lab1_wynik_tab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab1_wynik_tabRepository")
 */
class Lab1_wynik_tab
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
     * @ORM\Column(name="dl_sr", type="decimal", precision=10, scale=3)
     */
    private $dlSr;

    /**
     * @var string
     *
     * @ORM\Column(name="s_dl", type="decimal", precision=10, scale=3)
     */
    private $sdl;

    /**
     * @var string
     *
     * @ORM\Column(name="p", type="decimal", precision=10, scale=2)
     */
    private $p;

    /**
     * @ManyToOne(targetEntity="Lab1_wynik", inversedBy="tab")
     * @JoinColumn(name="id_wynik", referencedColumnName="id")
     */
    private $wynik;

    public function getP()
    {
        return $this->p;
    }

    public function setP($p)
    {
        $this->p = $p;
    }

    public function getWynik()
    {
        return $this->wynik;
    }

    public function setWynik($wynik)
    {
        $this->wynik = $wynik;
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
     * Set dl1
     *
     * @param string $dl1
     *
     * @return Lab1_wynik_tab
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
     * @return Lab1_wynik_tab
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
     * Set dlSr
     *
     * @param string $dlSr
     *
     * @return Lab1_wynik_tab
     */
    public function setDlSr($dlSr)
    {
        $this->dlSr = $dlSr;

        return $this;
    }

    /**
     * Get dlSr
     *
     * @return string
     */
    public function getDlSr()
    {
        return $this->dlSr;
    }


    public function getSdl()
    {
        return $this->sdl;
    }

    public function setSdl($sdl)
    {
        $this->sdl = $sdl;
    }
}

