<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Lab1_pomiar
 *
 * @ORM\Table(name="lab1_pomiar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab1_pomiarRepository")
 */
class Lab1_pomiar
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
     * @ORM\Column(name="l0", type="decimal", precision=10, scale=2)
     */
    private $l0;

    /**
     * @var string
     *
     * @ORM\Column(name="d0", type="decimal", precision=10, scale=2)
     */
    private $d0;

    /**
     * @var string
     *
     * @ORM\Column(name="du", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $du;

    /**
     * @var string
     *
     * @ORM\Column(name="lu", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $lu;

    /**
     * @var string
     *
     * @ORM\Column(name="Pm", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $pm;

    /**
     * @OneToOne(targetEntity="Zespol", inversedBy="lab1Pomiar")
     * @JoinColumn(name="id_zespol", referencedColumnName="id")
     */
    private $zespol;

    /**
     * @OneToMany(targetEntity="Lab1_pomiar_tab", mappedBy="pomiar")
     */
    private $tab;

  public function getZespol()
  {
    return $this->zespol;
  }

  public function setZespol($zespol)
  {
    $this->zespol = $zespol;
  }

  public function getTab()
  {
    return $this->tab;
  }

  public function setTab(Lab1_pomiar_tab $tab)
  {
    $this->tab = $tab;
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
     * Set l0
     *
     * @param string $l0
     *
     * @return Lab1_pomiar
     */
    public function setL0($l0)
    {
        $this->l0 = $l0;

        return $this;
    }

    /**
     * Get l0
     *
     * @return string
     */
    public function getL0()
    {
        return $this->l0;
    }

    /**
     * Set d0
     *
     * @param string $d0
     *
     * @return Lab1_pomiar
     */
    public function setD0($d0)
    {
        $this->d0 = $d0;

        return $this;
    }

    /**
     * Get d0
     *
     * @return string
     */
    public function getD0()
    {
        return $this->d0;
    }

    /**
     * Set du
     *
     * @param string $du
     *
     * @return Lab1_pomiar
     */
    public function setDu($du)
    {
        $this->du = $du;

        return $this;
    }

    /**
     * Get du
     *
     * @return string
     */
    public function getDu()
    {
        return $this->du;
    }

    /**
     * Set lu
     *
     * @param string $lu
     *
     * @return Lab1_pomiar
     */
    public function setLu($lu)
    {
        $this->lu = $lu;

        return $this;
    }

    /**
     * Get lu
     *
     * @return string
     */
    public function getLu()
    {
        return $this->lu;
    }

    /**
     * Set pm
     *
     * @param string $pm
     *
     * @return Lab1_pomiar
     */
    public function setPm($pm)
    {
        $this->pm = $pm;

        return $this;
    }

    /**
     * Get pm
     *
     * @return string
     */
    public function getPm()
    {
        return $this->pm;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Lab1_pomiar
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

  public function __toString() {
    return (string) $this->zespol;
  }
}
