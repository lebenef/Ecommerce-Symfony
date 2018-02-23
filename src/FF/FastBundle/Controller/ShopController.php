<?php

namespace FF\FastBundle\Controller;
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

					$listProduits = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						->getProduits($page, $nbPerPage)
           ;
            $listGammes = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->findAll()
						;

			   $nbPages = ceil(count($listProduits) / $nbPerPage);
 			 if ($page > $nbPages)
			 {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Shop:index.html.twig', array(
					'listProduits' => $listProduits,
          'listGammes' => $listGammes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
				
    }
  
	    public function gammeAction($page, $gamme)
    {
				dump($gamme);
				dump($page);
								
		 
    	if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }					 			$nbPerPage = 10;

					$listProduits = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						->getProduitsByGamme($gamme,$page, $nbPerPage)
           ;
            $listGammes = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->findAll()
						;
				dump($listProduits);
				dump($nbPerPage);
			   $nbPages = ceil(count($listProduits) / $nbPerPage);
 			 if ($page > $nbPages)
			 {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Shop:gamme.html.twig', array(
					'listProduits' => $listProduits,
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
			
			     $listGammes = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->findAll()
						;
				if (null === $produits) {
      throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
					}
						dump($produits);
      return $this->render('FFFast:Shop:view.html.twig', array(
          'produits' => $produits,
				  'listGammes' => $listGammes,
        ));
    }
}
		

