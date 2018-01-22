<?php
namespace UserBundle\Entity;
use AppBundle\Entity\Zespol;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @OneToMany(targetEntity="AppBundle\Entity\Project", mappedBy="user", cascade={"remove"})
     */
    protected $projects;

    public function getId()
    {
        return $this->id;
    }

  public function getProjects()
  {
    return $this->projects;
  }

  public function setProjects($projects)
  {
    $this->projects = $projects;
  }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function __toString()
    {
        return $this->id;
    }
}
