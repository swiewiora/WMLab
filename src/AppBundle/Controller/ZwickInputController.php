<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ZwickInput;
use AppBundle\Form\ZwickInputType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File as File;

/**
 * Lab1_pomiar controller.
 *
 * @Route("/zwick")
 */
class ZwickInputController extends Controller
{
    /**
     * Lists all Lab1_pomiar entities.
     *
     * @Route("/", name="zwick_input_list")
     * @Method("GET")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Route("/new", name="zwick_new")
     */
    public function newAction(Request $request) {
        $input = new ZwickInput();
        $input->setUser($this->getUser());
        $form = $this->createForm(ZwickInputType::class, $input);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var File\UploadedFile $file */
            $file = $input->getFile();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('csv_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $input->setBrochure($fileName);

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('zwick_input_list'));
        }

        return $this->render('zwick/upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
