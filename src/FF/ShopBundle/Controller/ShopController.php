<?php

namespace FF\ShopBundle\Controller;
use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FF\FastBundle\Entity\Gammes;
use FF\FastBundle\Form\GammesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ShopController extends Controller
{
    public function indexAction($page)
    {
								
		 
    	if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }					 			$nbPerPage = 10;

					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						->getProduits($page, $nbPerPage)
           ;
            $repository2 = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->getGammes($page, $nbPerPage)
						;
					$listProduits = $repository;
					$listGammes = $repository2;

			   $nbPages = ceil(count($listProduits) / $nbPerPage);
 			 if ($page > $nbPages)
			 {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFShopBundle:Shop:index.html.twig', array(
					'listProduits' => $listProduits,
          'listGammes' => $listGammes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
				
    }
  
  
  
	    public function menuAction()
    {
		 	$page = 1;
			$nbPerPage = 10;
					
			$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->getGammes($page, $nbPerPage)

						;
					$listGammes = $repository;
			 			dump($listGammes);

			   $nbPages = ceil(count($listGammes) / $nbPerPage);
 			 if ($page > $nbPages)
			 {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			

        return $this->render('FFShopBundle:Shop:menu.html.twig', array(
					'listGammes' => $listGammes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
    }
	
    public function viewAction($id)
      {			
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						;
					$produits = $repository->find($id);
			
				if (null === $produits) {
      throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
					}
						dump($produits);
      return $this->render('FFShopBundle:Shop:view.html.twig', array(
          'produits' => $produits
        ));
    }
}
		

