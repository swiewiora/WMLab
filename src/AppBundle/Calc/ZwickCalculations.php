<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2016-11-30
 * Time: 19:21
 */

namespace AppBundle\Calc;

use AppBundle\Entity\ZwickInput;
use AppBundle\Entity\ZwickInputData;
use AppBundle\Entity\ZwickOutput;
use AppBundle\Entity\ZwickOutputData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ZwickCalculations
{
    private $input, $output;
    private $time, $distance_standard, $load_measurement, $S, $v, $t_avg, $Eps, $U, $Ns, $flow_stress, $Sexp, $Sapr,
        $load_prediction, $d, $p, $d2;

    /**
     * Lab1Calc constructor.
     * @param ZwickInput $zwick_input
     */
    public function __construct(ZwickInput $zwick_input)
    {
        $this->input = $zwick_input;
        $this->calculate();
    }

    private function calculate()
    {
        $d0 = $this->input->getD0();
        $h0 = $this->input->getH0();
        $t0 = $this->input->getT0();
        $t1 = $this->input->getT1();

        $input_file_data = $this->input->getData();
        for($i = 0; $i < sizeof($input_file_data); $i++) {
            $this->time[$i] = $input_file_data[$i]->getTestTime();
            $this->distance_standard[$i] = $input_file_data->getDistanceStandard() + $this->input->getKorr();
            $this->load_measurement[$i] = $input_file_data->getLoadMeasurement();
        }

        for($i = 0; $i < sizeof($input_file_data); $i++) {
            $this->S[$i] = pi() * $d0^2 * $h0 / (4 * ($h0 - $this->distance_standard[$i]));
            $this->v[$i] = ($this->distance_standard[$i+1] - $this->distance_standard[$i])
                    / ($this->time[$i+1] - $this->time[$i+1]);
            $this->t_avg[$i] = $t0 + $t1 * $this->distance_standard[$i];
            $this->Eps[$i] = log($h0 / ($h0 - $this->distance_standard[$i]));
            $this->U[$i] = ($this->Eps[$i+1] - $this->Eps[$i]) / ($this->time[$i+1] - $this->time[$i]);
            $this->d[$i] = $d0 * sqrt($h0 / $h0 - $this->distance_standard[$i]);
            $this->Ns[$i] = 1 + 0.4 * $this->d[$i] / (3 * $h0 - $this->distance_standard[$i]);
            $this->Sexp[$i] = $this->load_measurement[$i] / $this->S[$i];
            $this->flow_stress[$i] = $this->Sexp[$i] / $this->Ns[$i];
            $this->Sapr[$i] = $this->sigmaMgCa08($this->Eps[$i], $this->U[$i], $this->t_avg[$i],
                1158.87119892742, 0.005703923, 0.188112152, 0.144087312, 0.5, 0);
            $this->load_prediction[$i] = $this->p[$i] * $this->S[$i];
            $this->p[$i] = $this->Sapr[$i] * $this->Ns[$i];
            $this->d2[$i] = ($this->load_measurement[$i] - $this->load_prediction[$i])^2;
        }
    }

    private function sigmaMgCa08($Strain_input, $StrainRate_input, $t_input, $A, $m1, $m2, $m3, $m4, $m5) {
        $Kstrain = $A * $Strain_input ^ $m2 * Exp(-$m4 * $Strain_input);
        $Ku = $StrainRate_input ^ ($m3 * (($t_input - 20) / 280) ^ $m5);
        $Kt = exp(-$m1 * $t_input);
        $Ktu = 1; //StrainRate_input ^ (m5 * t_input)
        return $Kstrain * $Ku * $Kt * $Ktu;
    }

    public function getOutput()
    {
        //Create new Entity and assign it to Project
        $this->output = new ZwickOutput();
        $this->output->setProject($this->input->getProject());

        return $this->output;
    }

    public function getOutputData()
    {
        $input_data = $this->input->getData();
        $output_data_tab = [];
        for ($i = 0; $i < sizeof($input_data); $i++) {
            $output_data_tab[$i] = new ZwickOutputData();
            $output_data_tab[$i]->setOutput($this->output);

            $output_data_tab[$i]->setDistanceStandard($this->distance_standard);
            $output_data_tab[$i]->setS($this->S);
            $output_data_tab[$i]->setV($this->v);
            $output_data_tab[$i]->setTAvg($this->t_avg);
            $output_data_tab[$i]->setEps($this->Eps);
            $output_data_tab[$i]->setU($this->U);
            $output_data_tab[$i]->setD($this->d);
            $output_data_tab[$i]->setNs($this->Ns);
            $output_data_tab[$i]->setSexp($this->Sexp);
            $output_data_tab[$i]->setFlowStress($this->flow_stress);
            $output_data_tab[$i]->setSapr($this->Sapr);
            $output_data_tab[$i]->setLoadPrediction($this->load_prediction);
            $output_data_tab[$i]->setP($this->p);
            $output_data_tab[$i]->setD2($this->d2);
        }

        return $output_data_tab;
    }
}