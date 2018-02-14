<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\GammeProduit;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GammesProduitsController extends Controller
{
    public function indexAction()
    {


	$gamme = "pizza";
        return $this->render('FFFastBundle:Gammes:index.html.twig', array('gammes' => $gamme) );
    }

    public function addAction()
    {
        return $this->render('FFFastBundle:Gammes:add.html.twig');
    }
}
