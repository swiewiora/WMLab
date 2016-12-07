<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Lab1_pomiar_tab
 *
 * @ORM\Table(name="lab1_pomiar_tab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab1_pomiar_tabRepository")
 */
class Lab1_pomiar_tab
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
     * @ORM\Column(name="P", type="decimal", precision=10, scale=2)
     */
    private $p;

    /**
     * @var string
     *
     * @ORM\Column(name="l1", type="decimal", precision=10, scale=2)
     */
    private $l1;

    /**
     * @var string
     *
     * @ORM\Column(name="l2", type="decimal", precision=10, scale=2)
     */
    private $l2;

    /**
     * @ManyToOne(targetEntity="Lab1_pomiar", inversedBy="tab")
     * @JoinColumn(name="id_pomiar", referencedColumnName="id")
     */
    private $pomiar;

    public function getPomiar()
    {
    return $this->pomiar;
    }

    public function setPomiar(Lab1_pomiar $pomiar)
  {
    $this->pomiar = $pomiar;
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
     * Set p
     *
     * @param string $p
     *
     * @return Lab1_pomiar_tab
     */
    public function setP($p)
    {
        $this->p = $p;

        return $this;
    }

    /**
     * Get p
     *
     * @return string
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * Set l1
     *
     * @param string $l1
     *
     * @return Lab1_pomiar_tab
     */
    public function setL1($l1)
    {
        $this->l1 = $l1;

        return $this;
    }

    /**
     * Get l1
     *
     * @return string
     */
    public function getL1()
    {
        return $this->l1;
    }

    /**
     * Set l2
     *
     * @param string $l2
     *
     * @return Lab1_pomiar_tab
     */
    public function setL2($l2)
    {
        $this->l2 = $l2;

        return $this;
    }

    /**
     * Get l2
     *
     * @return string
     */
    public function getL2()
    {
        return $this->l2;
    }
}

