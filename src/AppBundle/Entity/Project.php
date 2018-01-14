<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-12-22
 * Time: 20:49
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @OneToMany(targetEntity="AppBundle\Entity\Material", mappedBy="project", cascade={"remove"})
     */
    private $materials;
    /**
     * @OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="project")
     */
    private $user;

    //region getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function getMaterials()
    {
        return $this->materials;
    }

    public function setMaterials($materials)
    {
        $this->materials = $materials;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
    //endregion
}