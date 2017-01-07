<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2016-11-30
 * Time: 19:21
 */

namespace AppBundle\Calc;

use AppBundle\Entity\Lab1_pomiar;
use AppBundle\Entity\Lab1_wynik;
use AppBundle\Entity\Lab1_wynik_tab;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Lab1Calc
{
    private $s0;
    private $su;
    private $a10;
    private $z;
    private $rel;
    private $reh;
    private $rm;
    private $ru;
    private $dl1, $dl2, $dl, $sdl, $p;
    private $lab1_pomiar, $lab1_wynik;

    /**
     * Lab1Calc constructor.
     * @param Lab1_pomiar $lab1_pomiar
     */
    public function __construct(Lab1_pomiar $lab1_pomiar)
    {
        $this->lab1_pomiar = $lab1_pomiar;
        $this->calculate($lab1_pomiar);
    }

    public function getWynik()
    {
        return $this->toWynik($this->lab1_pomiar);
    }

    public function getWynikTab()
    {
        return $this->toWynikTab($this->lab1_pomiar);
    }

    private function calculate(Lab1_pomiar $lab1_pomiar)
    {
        $d0 = $lab1_pomiar->getD0();
        $this->s0 = pi() * pow((double) $d0, 2) / 4;

        $du = $lab1_pomiar->getDu();
        $this->su = pi() * pow((double) $du, 2) / 4;

        $l0 = $lab1_pomiar->getL0();
        $lu = $lab1_pomiar->getLu();
        $this->a10 = ($lu - $l0) / $l0 * 100;

        $this->z = ($this->s0 - $this->su) / $this->s0 * 100;

        $pel = $lab1_pomiar->getPel();
        $this->rel = $pel / $this->s0;

        $peh = $lab1_pomiar->getPeh();
        $this->reh = $peh / $this->s0;

        $pm = $lab1_pomiar->getPm();
        $this->rm = $pm / $this->s0;

        $pu = $lab1_pomiar->getPu();
        $this->ru = $pu / $this->su;

        $lab1_pomiar_tab = $lab1_pomiar->getTab();
        for($i = 0; $i < sizeof($lab1_pomiar_tab); $i++) {
            $this->p[$i] = $lab1_pomiar_tab[$i]->getP();
            $this->dl1[$i] = $lab1_pomiar_tab[$i]->getL1();
            $this->dl2[$i] = $lab1_pomiar_tab[$i]->getL2();

            if($i != 0) {
                $this->dl1[$i] -= $lab1_pomiar_tab[$i - 1]->getL1();
                $this->dl2[$i] -= $lab1_pomiar_tab[$i - 1]->getL2();
            }

            $this->dl[$i] = ($this->dl1[$i] + $this->dl2[$i]) / (2 * 100);
            $this->sdl[$i] = $this->dl[$i];

            if($i != 0)
                $this->sdl[$i] += $this->sdl[$i-1];


        }
    }

    private function toWynik(Lab1_pomiar $lab1_pomiar)
    {
        //Create new Lab1_wynik entity and connect it with Team
        $this->lab1_wynik = new Lab1_wynik();
        if($zespol = $lab1_pomiar->getZespol())
            $this->lab1_wynik->setZespol($zespol);

        // Set results to Lab1_wynik entity
        $this->lab1_wynik->setS0($this->s0);
        $this->lab1_wynik->setSu($this->su);
        $this->lab1_wynik->setA10($this->a10);
        $this->lab1_wynik->setZ($this->z);
        $this->lab1_wynik->setReL($this->rel);
        $this->lab1_wynik->setReH($this->reh);
        $this->lab1_wynik->setRm($this->rm);
        $this->lab1_wynik->setRu($this->ru);

        return $this->lab1_wynik;
    }

    private function toWynikTab(Lab1_pomiar $lab1_pomiar)
    {
        for($i = 0; $i < sizeof($this->p); $i++)
        {
            $lab1_wynik_tab[$i] = new Lab1_wynik_tab();
            $lab1_wynik_tab[$i]->setWynik($this->lab1_wynik);

            $lab1_wynik_tab[$i]->setP($this->p[$i]);
            $lab1_wynik_tab[$i]->setDl1($this->dl1[$i]);
            $lab1_wynik_tab[$i]->setDl2($this->dl2[$i]);
            $lab1_wynik_tab[$i]->setDlSr($this->dl[$i]);
            $lab1_wynik_tab[$i]->setSdl($this->sdl[$i]);
        }

        return $lab1_wynik_tab;
    }
}