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
     * @OneToMany(targetEntity="AppBundle\Entity\ZwickInput", mappedBy="project", cascade={"remove"})
     */
    private $zwick_input;
    /**
     * @OneToMany(targetEntity="AppBundle\Entity\ZwickOutput", mappedBy="project", cascade={"remove"})
     */
    private $zwick_output;
    /**
     * @OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="project")
     */
    private $user;

    public function getZwickInput()
    {
        return $this->zwick_input;
    }

    public function setZwickInput($zwick_input)
    {
        $this->zwick_input = $zwick_input;
    }

    public function getZwickOutput()
    {
        return $this->zwick_output;
    }

    public function setZwickOutput($zwick_output)
    {
        $this->zwick_output = $zwick_output;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}