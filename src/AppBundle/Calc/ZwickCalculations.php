<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2016-11-30
 * Time: 19:21
 */

namespace AppBundle\Calc;

use AppBundle\Entity\Zwick;
use AppBundle\Entity\ZwickData;
use AppBundle\Entity\ZwickOutput;
use AppBundle\Entity\ZwickOutputData;

class ZwickCalculations
{
  private $zwick, $time, $distance_standard, $load_measurement, $S, $Eps, $Sexp, $load_prediction, $p;

  /**
   * Lab1Calc constructor.
   * @param Zwick $zwick
   */
  public function __construct(Zwick $zwick)
  {
    $this->zwick = $zwick;
  }

  public function calculateData()
  {
    // get input values
    $d0 = $this->zwick->getD0();
    $h0 = $this->zwick->getH0();

    $zwick_file_data = $this->zwick->getData();
    /** @var ZwickData $data_row */
    $data_row = $zwick_file_data[0];
    $this->time[0] = $data_row->getTestTime();
    $this->distance_standard[0] = $data_row->getDistanceStandard();
    $this->load_measurement[0] = $data_row->getLoadMeasurement();

    $this->Eps[0] = log($h0 / ($h0 - $this->distance_standard[0]));

    for ($i = 0; $i < sizeof($zwick_file_data); $i++) {
      /** @var ZwickData $data_row
       * @var ZwickData $next_data_row
       */
      $data_row = $zwick_file_data[$i];
      if ($i < (sizeof($zwick_file_data) - 1)) {
        $next_data_row = $zwick_file_data[$i + 1];
        $this->time[$i + 1] = $next_data_row->getTestTime();
        $this->distance_standard[$i + 1] = $next_data_row->getDistanceStandard();
        $this->load_measurement[$i + 1] = $next_data_row->getLoadMeasurement();
      }
      if ($i == (sizeof($zwick_file_data) - 1)) {
        $this->time[$i + 1] = 0;
        $this->distance_standard[$i + 1] = 0;
        $this->load_measurement[$i + 1] = 0;
      }

      $this->S[$i] = pi() * pow($d0, 2) * $h0 / (4 * ($h0 - $this->distance_standard[$i]));
      $this->Eps[$i + 1] = log($h0 / ($h0 - $this->distance_standard[$i + 1]));
      $this->Sexp[$i] = $this->load_measurement[$i] / $this->S[$i];
      $this->load_prediction[$i] = $this->p[$i] * $this->S[$i];

      // save the results
      $data_row->setS($this->S[$i]);
      $data_row->setEps($this->Eps[$i]);
      $data_row->setSexp($this->Sexp[$i]);
    }

    return $zwick_file_data;
  }

  public function getZwick()
  {
    return $this->zwick;
  }
}