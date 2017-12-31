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
     * @ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="zwick")
     * @JoinColumn(name="id_project", referencedColumnName="id")
     */
    private $project;
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the CSV data.")
     * @Assert\File(mimeTypes={ "text/plain" })
     */
    private $file;
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
    private $t1;
    /**
     * @ORM\Column(type="float")
     */
    private $korr;

    public function getId()
    {
        return $this->id;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
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
}