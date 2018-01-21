<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2018-01-06
 * Time: 13:24
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaterialRepository")
 * @ORM\Table(name="material")
 */
class Material
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $alloyName;
    /**
     * @ORM\Column(type="string")
     */
    private $chemicalComposition;
    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="materials")
     * @JoinColumn(name="id_project", referencedColumnName="id")
     */
    private $project;
    /**
     * @OneToMany(targetEntity="AppBundle\Entity\Zwick", mappedBy="material", cascade={"remove"})
     */
    private $tasks;

    //region getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function getAlloyName()
    {
        return $this->alloyName;
    }

    public function setAlloyName($alloyName)
    {
        $this->alloyName = $alloyName;
    }

    public function getChemicalComposition()
    {
        return $this->chemicalComposition;
    }

    public function setChemicalComposition($chemicalComposition)
    {
        $this->chemicalComposition = $chemicalComposition;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }

    public function getTasks()
    {
        return $this->tasks;
    }

    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }
    //endregion
}