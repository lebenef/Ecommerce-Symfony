<?php

namespace FF\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FFCoreBundle:Default:index.html.twig');
    }
}
