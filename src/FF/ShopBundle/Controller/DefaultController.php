<?php

namespace FF\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FFShopBundle:Default:index.html.twig');
    }
}
