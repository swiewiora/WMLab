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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
   * @ORM\Column(type="float")
   */
  private $distance_standard_korr;
  /**
   * @ORM\Column(type="float")
   */
  private $S;
  /**
   * @ORM\Column(type="float")
   */
  private $v;
  /**
   * @ORM\Column(type="float")
   */
  private $t_avg;
  /**
   * @ORM\Column(type="float")
   */
  private $Eps;
  /**
   * @ORM\Column(type="float")
   */
  private $U;
  /**
   * @ORM\Column(type="float")
   */
  private $Ns;
  /**
   * @ORM\Column(type="float")
   */
  private $flow_stress;
  /**
   * @ORM\Column(type="float")
   */
  private $Sexp;
  /**
   * @ORM\Column(type="float")
   */
  private $Sapr;
  /**
   * @ORM\Column(type="float")
   */
  private $load_prediction;
  /**
   * @ORM\Column(type="float")
   */
  private $d;
  /**
   * @ORM\Column(type="float")
   */
  private $p;
  /**
   * @ORM\Column(type="float")
   */
  private $d2;

  public function getDistanceStandardKorr()
  {
    return $this->distance_standard_korr;
  }

  public function setDistanceStandardKorr($distance_standard_korr)
  {
    $this->distance_standard_korr = $distance_standard_korr;
  }

  public function getS()
  {
    return $this->S;
  }

  public function setS($S)
  {
    $this->S = $S;
  }

  public function getV()
  {
    return $this->v;
  }

  public function setV($v)
  {
    $this->v = $v;
  }

  public function getTAvg()
  {
    return $this->t_avg;
  }

  public function setTAvg($t_avg)
  {
    $this->t_avg = $t_avg;
  }

  public function getEps()
  {
    return $this->Eps;
  }

  public function setEps($Eps)
  {
    $this->Eps = $Eps;
  }

  public function getU()
  {
    return $this->U;
  }

  public function setU($U)
  {
    $this->U = $U;
  }

  public function getNs()
  {
    return $this->Ns;
  }

  public function setNs($Ns)
  {
    $this->Ns = $Ns;
  }

  public function getFlowStress()
  {
    return $this->flow_stress;
  }

  public function setFlowStress($flow_stress)
  {
    $this->flow_stress = $flow_stress;
  }

  public function getSexp()
  {
    return $this->Sexp;
  }

  public function setSexp($Sexp)
  {
    $this->Sexp = $Sexp;
  }

  public function getSapr()
  {
    return $this->Sapr;
  }

  public function setSapr($Sapr)
  {
    $this->Sapr = $Sapr;
  }

  public function getLoadPrediction()
  {
    return $this->load_prediction;
  }

  public function setLoadPrediction($load_prediction)
  {
    $this->load_prediction = $load_prediction;
  }

  public function getD()
  {
    return $this->d;
  }

  public function setD($d)
  {
    $this->d = $d;
  }

  public function getP()
  {
    return $this->p;
  }

  public function setP($p)
  {
    $this->p = $p;
  }

  public function getD2()
  {
    return $this->d2;
  }

  public function setD2($d2)
  {
    $this->d2 = $d2;
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
}