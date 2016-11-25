<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Lab2_pomiar_tab
 *
 * @ORM\Table(name="lab2_pomiar_tab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lab2_pomiar_tabRepository")
 */
class Lab2_pomiar_tab
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
     * @ORM\Column(name="N", type="decimal", precision=10, scale=2)
     */
    private $n;

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
     * @var string
     *
     * @ORM\Column(name="l3", type="decimal", precision=10, scale=2)
     */
    private $l3;

      /**
   * @ManyToOne(targetEntity="Lab2_pomiar", inversedBy="tab")
   * @JoinColumn(name="id_pomiar", referencedColumnName="id")
   */
    private $pomiar;

    public function getPomiar()
    {
        return $this->pomiar;
    }

    public function setPomiar($pomiar)
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
     * Set n
     *
     * @param string $n
     *
     * @return Lab2_pomiar_tab
     */
    public function setN($n)
    {
        $this->n = $n;

        return $this;
    }

    /**
     * Get n
     *
     * @return string
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * Set l1
     *
     * @param string $l1
     *
     * @return Lab2_pomiar_tab
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
     * @return Lab2_pomiar_tab
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

    /**
     * Set l3
     *
     * @param string $l3
     *
     * @return Lab2_pomiar_tab
     */
    public function setL3($l3)
    {
        $this->l3 = $l3;

        return $this;
    }

    /**
     * Get l3
     *
     * @return string
     */
    public function getL3()
    {
        return $this->l3;
    }
}

