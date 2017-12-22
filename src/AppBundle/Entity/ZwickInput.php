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

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZwickInputRepository")
 * @ORM\Table(name="zwick_input")
 */
class ZwickInput
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="float")
     */
    private $test_time;
    /**
     * @ORM\Column(type="float")
     */
    private $distance_standard;
    /**
     * @ORM\Column(type="float")
     */
    private $load_measurement;
    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="zwick_input")
     * @JoinColumn(name="id_project", referencedColumnName="id")
     */
    private $project;
}