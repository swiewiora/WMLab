<?php
namespace UserBundle\Entity;
use AppBundle\Entity\Zespol;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
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
     * @ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="user")
     * @JoinColumn(name="id_project", referencedColumnName="id")
     */
    protected $project;

    public function getId()
    {
        return $this->id;
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
