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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTestTime()
    {
        return $this->test_time;
    }

    public function setTestTime($test_time)
    {
        $this->test_time = $test_time;
    }

    public function getDistanceStandard()
    {
        return $this->distance_standard;
    }

    public function setDistanceStandard($distance_standard)
    {
        $this->distance_standard = $distance_standard;
    }

    public function getLoadMeasurement()
    {
        return $this->load_measurement;
    }

    public function setLoadMeasurement($load_measurement)
    {
        $this->load_measurement = $load_measurement;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial($material)
    {
        $this->material = $material;
    }
}