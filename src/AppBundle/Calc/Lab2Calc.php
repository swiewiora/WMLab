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

class Lab2Calc
{
    private $s0;
    private $su;
    private $a10;
    private $z;
    private $rel;
    private $reh;
    private $rm;
    private $ru;

    public function getWynik(Lab1_pomiar $lab1_pomiar)
    {
        $this->calculate($lab1_pomiar);
        return $this->toWynik($lab1_pomiar);
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

    }

    private function toWynik(Lab1_pomiar $lab1_pomiar)
    {
        //Create new Lab1_wynik entity and connect it with Team
        $lab1_wynik = new Lab1_wynik();
        $lab1_wynik->setZespol($lab1_pomiar->getZespol());

        // Set results to Lab1_wynik entity
        $lab1_wynik->setS0($this->s0);
        $lab1_wynik->setSu($this->su);
        $lab1_wynik->setA10($this->a10);
        $lab1_wynik->setZ($this->z);
        $lab1_wynik->setReL($this->rel);
        $lab1_wynik->setReH($this->reh);
        $lab1_wynik->setRm($this->rm);
        $lab1_wynik->setRu($this->ru);

        return $lab1_wynik;
    }
}