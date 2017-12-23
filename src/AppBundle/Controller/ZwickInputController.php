<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ZwickInput;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ZwickInputController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function uploadAction(Request $request) {
        $input = new ZwickInput();
        $input->setUser($this->getUser());
    }
}
