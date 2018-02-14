<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Gammes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GammesController extends Controller
{
    public function indexAction()
    {


	$gamme = "pizza";
        return $this->render('FFFastBundle:Gammes:index.html.twig', array('gammes' => $gamme) );
    }

    public function addAction()
    {
    	$gammes = new Gammes();

    	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class,Gamme);

    	$formBuilder
	      ->add('date',      DateType::class)
	      ->add('name',     TextType::class)
	      ->add('description',   TextareaType::class)
	      ->add('save',      SubmitType::class)
	      ;


	      $form = $formBuilder->getForm();

        return $this->render('FFFastBundle:Gammes:add.html.twig', array(
        	'form' => $form->createView(),
        	));
    }
}
