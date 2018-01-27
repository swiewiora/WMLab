<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZwickDataRepository")
 * @ORM\Table(name="zwick_data")
 */
class ZwickData
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;
  /**
   * @ManyToOne(targetEntity="AppBundle\Entity\Zwick", inversedBy="data")
   * @JoinColumn(name="id_input", referencedColumnName="id")
   */
  private $zwick;
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
   * @ORM\Column(type="float", nullable=true)
   */
  private $S;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $Eps;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $Sexp;

//region getters and setters

  public function getS()
  {
    return $this->S;
  }

  public function setS($S)
  {
    $this->S = $S;
  }

  public function getEps()
  {
    return $this->Eps;
  }

  public function setEps($Eps)
  {
    $this->Eps = $Eps;
  }

  public function getSexp()
  {
    return $this->Sexp;
  }

  public function setSexp($Sexp)
  {
    $this->Sexp = $Sexp;
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

  public function getZwick()
  {
    return $this->zwick;
  }

  public function setZwick($zwick)
  {
    $this->zwick = $zwick;
  }
  //endregion
}