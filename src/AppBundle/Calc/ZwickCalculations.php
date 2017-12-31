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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ZwickCalculations
{
    private $zwick;
    private $time, $distance_standard, $load_measurement, $S, $v, $t_avg, $Eps, $U, $Ns, $flow_stress, $Sexp, $Sapr,
        $load_prediction, $d, $p, $d2;

    /**
     * Lab1Calc constructor.
     * @param Zwick $zwick
     */
    public function __construct(Zwick $zwick)
    {
        $this->zwick = $zwick;
//        $this->calculate();
    }

    public function calculateData()
    {
        $d0 = $this->zwick->getD0();
        $h0 = $this->zwick->getH0();
        $t0 = $this->zwick->getT0();
        $t1 = $this->zwick->getT1();
        $korr = $this->zwick->getKorr();

        $zwick_file_data = $this->zwick->getData();
            /** @var ZwickData $data_row */
            $data_row = $zwick_file_data[0];
            $this->time[0] = $data_row->getTestTime();
            $this->distance_standard[0] = $data_row->getDistanceStandard() + $korr;
            $this->load_measurement[0] = $data_row->getLoadMeasurement();

            $this->Eps[0] = log($h0 / ($h0 - $this->distance_standard[0]));

        for($i = 0; $i < sizeof($zwick_file_data); $i++) {
            /**
             * @var ZwickData $data_row
             * @var ZwickData $next_data_row
             */
            $data_row = $zwick_file_data[$i];
            if ($i < (sizeof($zwick_file_data) - 1) ) {
                $next_data_row = $zwick_file_data[$i+1];
                $this->time[$i + 1] = $next_data_row->getTestTime();
                $this->distance_standard[$i + 1] = $next_data_row->getDistanceStandard() + $korr;
                $this->load_measurement[$i + 1] = $next_data_row->getLoadMeasurement();
            }
            if ($i == (sizeof($zwick_file_data) - 1) ) {
                $this->time[$i + 1] = 0;
                $this->distance_standard[$i + 1] = 0;
                $this->load_measurement[$i + 1] = 0;
            }

            $this->S[$i] = pi() * pow($d0,2) * $h0 / (4 * ($h0 - $this->distance_standard[$i]));
            $this->v[$i] = ($this->distance_standard[$i+1] - $this->distance_standard[$i])
                / ($this->time[$i+1] - $this->time[$i]);
            $this->t_avg[$i] = $t0 + $t1 * $this->distance_standard[$i];
            $this->Eps[$i+1] = log($h0 / ($h0 - $this->distance_standard[$i+1]));

            $this->U[$i] = ($this->Eps[$i+1] - $this->Eps[$i]) / ($this->time[$i+1] - $this->time[$i]);
            $this->d[$i] = $d0 * sqrt($h0 / $h0 - $this->distance_standard[$i]);
            $this->Ns[$i] = 1 + 0.4 * $this->d[$i] / (3 * $h0 - $this->distance_standard[$i]);
            $this->Sexp[$i] = $this->load_measurement[$i] / $this->S[$i];
            $this->flow_stress[$i] = $this->Sexp[$i] / $this->Ns[$i];
            $this->Sapr[$i] = $this->sigmaMgCa08($this->Eps[$i], $this->U[$i], $this->t_avg[$i],
                1158.87119892742, 0.005703923, 0.188112152, 0.144087312, 0.5, 0);
            $this->p[$i] = $this->Sapr[$i] * $this->Ns[$i];
            $this->load_prediction[$i] = $this->p[$i] * $this->S[$i];
            $this->d2[$i] = pow( ($this->load_measurement[$i] - $this->load_prediction[$i]),2);

            $data_row->setDistanceStandardKorr($this->distance_standard[$i]);
            $data_row->setS($this->S[$i]);
            $data_row->setV($this->v[$i]);
            $data_row->setTAvg($this->t_avg[$i]);
            $data_row->setEps($this->Eps[$i]);
            $data_row->setU($this->U[$i]);
            $data_row->setD($this->d[$i]);
            $data_row->setNs($this->Ns[$i]);
            $data_row->setSexp($this->Sexp[$i]);
            $data_row->setFlowStress($this->flow_stress[$i]);
            $data_row->setSapr($this->Sapr[$i]);
            $data_row->setLoadPrediction($this->load_prediction[$i]);
            $data_row->setP($this->p[$i]);
            $data_row->setD2($this->d2[$i]);
        }

        return $zwick_file_data;
    }

    private function sigmaMgCa08($Strain_input, $StrainRate_input, $t_input, $A, $m1, $m2, $m3, $m4, $m5) {
        $Kstrain = $A * pow($Strain_input, $m2) * Exp(-$m4 * $Strain_input);
        $Ku = pow($StrainRate_input, ($m3 * pow( ( ($t_input - 20) / 280), $m5) ) );
        $Kt = exp(-$m1 * $t_input);
        $Ktu = 1; //pow(StrainRate_input, (m5 * t_input) )
        return $Kstrain * $Ku * $Kt * $Ktu;
    }

    public function getZwick()
    {
        //Create new Entity and assign it to Project
//        $this->zwick = new Zwick();
//        $this->zwick->setProject($this->zwick->getProject());

        return $this->zwick;
    }

//    public function getOutputData()
//    {
//        $input_data = $this->zwick->getData();
//        $output_data_tab = [];
//        for ($i = 0; $i < sizeof($input_data); $i++) {
//            $output_data_tab[$i] = new ZwickData();
////            $output_data_tab[$i]->setZwick($this->zwick);
//            $output_data_tab[$i]->setDistanceStandardKorr($this->distance_standard);
//            $output_data_tab[$i]->setS($this->S);
//            $output_data_tab[$i]->setV($this->v);
//            $output_data_tab[$i]->setTAvg($this->t_avg);
//            $output_data_tab[$i]->setEps($this->Eps);
//            $output_data_tab[$i]->setU($this->U);
//            $output_data_tab[$i]->setD($this->d);
//            $output_data_tab[$i]->setNs($this->Ns);
//            $output_data_tab[$i]->setSexp($this->Sexp);
//            $output_data_tab[$i]->setFlowStress($this->flow_stress);
//            $output_data_tab[$i]->setSapr($this->Sapr);
//            $output_data_tab[$i]->setLoadPrediction($this->load_prediction);
//            $output_data_tab[$i]->setP($this->p);
//            $output_data_tab[$i]->setD2($this->d2);
//        }
//
//        return $output_data_tab;
//    }
}