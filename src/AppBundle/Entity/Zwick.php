<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-12-22
 * Time: 22:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZwickRepository")
 * @ORM\Table(name="zwick")
 */
class Zwick
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @OneToMany(targetEntity="AppBundle\Entity\ZwickData",
     *     mappedBy="zwick",
     *     cascade={"remove"})
     */
    private $data;
    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\Material", inversedBy="tasks")
     * @JoinColumn(name="id_material", referencedColumnName="id")
     */
    private $material;
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the CSV data.")
     * @Assert\File(mimeTypes={ "text/plain" })
     */
    private $fileTra;
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the PDF data.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $filePdf;
    /**
     * @ORM\Column(type="float")
     */
    private $d0;
    /**
     * @ORM\Column(type="float")
     */
    private $h0;
    /**
     * @ORM\Column(type="float")
     */
    private $t0;
    /**
     * @ORM\Column(type="float")
     */
    private $v0;
    /**
     * @ORM\Column(type="float")
     */
    private $ag;
    /**
     * @ORM\Column(type="float")
     */
    private $agt;
    /**
     * @ORM\Column(type="float")
     */
    private $at;
    /**
     * @ORM\Column(type="float")
     */
    private $e;
    /**
     * @ORM\Column(type="float")
     */
    private $r;
    /**
     * @ORM\Column(type="float")
     */
    private $fm;
    /**
     * @ORM\Column(type="float")
     */
    private $rm;
    /**
     * @ORM\Column(type="float")
     */
    private $rb;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $t1;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $korr;

    //region Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function getAgt()
    {
        return $this->agt;
    }

    public function setAgt($agt)
    {
        $this->agt = $agt;
    }

    public function getAg()
    {
        return $this->ag;
    }

    public function setAg($ag)
    {
        $this->ag = $ag;
    }

    public function getAt()
    {
        return $this->at;
    }

    public function setAt($at)
    {
        $this->at = $at;
    }

    public function getE()
    {
        return $this->e;
    }

    public function setE($e)
    {
        $this->e = $e;
    }

    public function getR()
    {
        return $this->r;
    }

    public function setR($r)
    {
        $this->r = $r;
    }

    public function getFm()
    {
        return $this->fm;
    }

    public function setFm($fm)
    {
        $this->fm = $fm;
    }

    public function getRm()
    {
        return $this->rm;
    }

    public function setRm($rm)
    {
        $this->rm = $rm;
    }

    public function getRb()
    {
        return $this->rb;
    }

    public function setRb($rb)
    {
        $this->rb = $rb;
    }

    public function getFilePdf()
    {
        return $this->filePdf;
    }

    public function setFilePdf($filePdf)
    {
        $this->filePdf = $filePdf;
    }

    public function getV0()
    {
        return $this->v0;
    }

    public function setV0($v0)
    {
        $this->v0 = $v0;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial($material)
    {
        $this->material = $material;
    }

    public function getFileTra()
    {
        return $this->fileTra;
    }

    public function setFileTra($fileTra)
    {
        $this->fileTra = $fileTra;
    }

    public function getD0()
    {
        return $this->d0;
    }

    public function setD0($d0)
    {
        $this->d0 = $d0;
    }

    public function getH0()
    {
        return $this->h0;
    }

    public function setH0($h0)
    {
        $this->h0 = $h0;
    }

    public function getT0()
    {
        return $this->t0;
    }

    public function setT0($t0)
    {
        $this->t0 = $t0;
    }

    public function getT1()
    {
        return $this->t1;
    }

    public function setT1($t1)
    {
        $this->t1 = $t1;
    }

    public function getKorr()
    {
        return $this->korr;
    }

    public function setKorr($korr)
    {
        $this->korr = $korr;
    }
    //endregion
}