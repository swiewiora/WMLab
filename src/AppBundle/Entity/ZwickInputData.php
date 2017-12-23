<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-12-23
 * Time: 12:27
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZwickInputDataRepository")
 * @ORM\Table(name="zwick_input_data")
 */
class ZwickInputData
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
     * @ManyToOne(targetEntity="AppBundle\Entity\ZwickInput", inversedBy="data")
     * @JoinColumn(name="id_input", referencedColumnName="id")
     */
    private $material;
}