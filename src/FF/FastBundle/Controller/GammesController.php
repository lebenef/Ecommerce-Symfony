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

    $listGammes   = array(
      array(
        'name'   => 'Pizza',
        'id'      => 1,
        'description'  => 'ronde',
        'date'    => new \Datetime()),
      array(
        'name'   => 'Agoulou',
        'id'      => 2,
        'description'  => 'rond',
        'date'    => new \Datetime()),
      array(
        'name'   => 'Bokit',
        'id'      => 3,
        'description'  => 'rond',
        'date'    => new \Datetime())
    );

        return $this->render('FFFastBundle:Gammes:index.html.twig', array('listGammes' => $listGammes) );
    }

    public function addAction()
    {
    	$gammes = new Gammes();

    	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class,$gammes);

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

    public function viewAction($id)
      {
        $gammes = array(
          'name'   => 'Pizza',
          'id'      => $id,
          'description'  => 'ronde',
          'date'    => new \Datetime()
        );

        return $this->render('FFFastBundle:Gammes:view.html.twig', array(
          'gamme' => $gamme
        ));
      }


    public function editAction()
    {
        $gammes = new Gammes();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class,$gammes);

        $formBuilder
          ->add('date',      DateType::class)
          ->add('name',     TextType::class)
          ->add('description',   TextareaType::class)
          ->add('save',      SubmitType::class)
          ;


          $form = $formBuilder->getForm();

        return $this->render('FFFastBundle:Gammes:edit.html.twig', array(
            'form' => $form->createView(),
            ));
    }

}