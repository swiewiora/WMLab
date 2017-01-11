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
     * @var Zespol
     * @ManyToOne(targetEntity="AppBundle\Entity\Zespol", inversedBy="user")
     * @JoinColumn(name="id_zespol", referencedColumnName="id")
     */
    protected $zespol;



    public function getZespol()
    {
        return $this->zespol;
    }
    public function setZespol($zespol)
    {
        $this->zespol = $zespol;
    }

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
