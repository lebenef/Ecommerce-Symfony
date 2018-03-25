<?php

namespace FF\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FFUserBundle:Default:index.html.twig');
    }
}
