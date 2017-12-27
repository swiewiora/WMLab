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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Lab1Calc
{
//    private $s0;
//    private $su;
//    private $a10;
//    private $z;
//    private $rel;
//    private $reh;
//    private $rm;
//    private $ru;
//    private $dl1, $dl2, $dl, $sdl, $p;
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

    public function getWynik()
    {
        return $this->toWynik($this->input);
    }

    public function getWynikTab()
    {
        return $this->toWynikTab($this->input);
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
    private function toWynik(ZwickInput $lab1_pomiar)
    {
        //Create new Lab1_wynik entity and connect it with Team
        $this->output = new Lab1_wynik();
        if($zespol = $lab1_pomiar->getZespol())
            $this->output->setZespol($zespol);

        // Set results to Lab1_wynik entity
        $this->output->setS0($this->s0);
        $this->output->setSu($this->su);
        $this->output->setA10($this->a10);
        $this->output->setZ($this->z);
        $this->output->setReL($this->rel);
        $this->output->setReH($this->reh);
        $this->output->setRm($this->rm);
        $this->output->setRu($this->ru);

        return $this->output;
    }

    private function toWynikTab(ZwickInput $lab1_pomiar)
    {
        for($i = 0; $i < sizeof($this->p); $i++)
        {
            $lab1_wynik_tab[$i] = new Lab1_wynik_tab();
            $lab1_wynik_tab[$i]->setWynik($this->output);

            $lab1_wynik_tab[$i]->setP($this->p[$i]);
            $lab1_wynik_tab[$i]->setDl1($this->dl1[$i]);
            $lab1_wynik_tab[$i]->setDl2($this->dl2[$i]);
            $lab1_wynik_tab[$i]->setDlSr($this->dl[$i]);
            $lab1_wynik_tab[$i]->setSdl($this->sdl[$i]);
        }

        return $lab1_wynik_tab;
    }
}