<?php

namespace FF\FastBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FFFastBundle:Default:index.html.twig');
    }
}
