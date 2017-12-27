<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-12-27
 * Time: 17:59
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity
 * @ORM\Table(name="zwick_output")
 */
class ZwickOutput
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @OneToMany(targetEntity="AppBundle\Entity\ZwickOutputData",
     *     mappedBy="input",
     *     cascade={"remove"})
     */
    private $data;
    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="zwick_output")
     * @JoinColumn(name="id_project", referencedColumnName="id")
     */
    private $project;

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
}