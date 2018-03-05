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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ShopController extends Controller
{
    public function indexAction(Request $request, $page)
    {         
				$session = $request->getSession();
		    if (!$session->has('panier')) $session->set('panier',array());
        		$panier = $session->get('panier');						
		 
    		if ($page < 1) 
				{
					throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    		}					 			
				$nbPerPage = 10;

				$listProduits = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getProduits($page, $nbPerPage);
				$listGammes = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Gammes')
					->findAll();

			  $nbPages = ceil(count($listProduits) / $nbPerPage);
			
				if ($page > $nbPages)
				{
					 throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Shop:index.html.twig', array(
						'listProduits' => $listProduits,
						'listGammes' => $listGammes,
						'nbPages'         => $nbPages,
						'page'            => $page,			
						'panier' => $session->get('panier')
				));
    }
  
	  public function gammeAction(Request $request, $page, $gamme)
    {
			dump($gamme);
			dump($page);

			$session = $request->getSession();

			if (!$session->has('panier')) $session->set('panier',array());
				$panier = $session->get('panier');	
			if ($page < 1)
			{
					throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}					 			
			$nbPerPage = 10;

			$listProduits = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Produits')
				->getProduitsByGamme($gamme,$page, $nbPerPage);
			$listGammes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Gammes')
				->findAll();
			
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
				'page'            => $page,	
				'panier' => $session->get('panier')
			));
				
    }
  
  
	
	public function viewAction(Request $request, $idProduits)
	{		


		$session = $request->getSession();
		if (!$session->has('panier')) $session->set('panier', array());  
			$repository = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Produits');
		
			$produits = $repository->find($idProduits);

			$listGammes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Gammes')
				->findAll()
				;
			if (null === $produits) 
			{
				throw new NotFoundHttpException("Le Produit d'id ".$idProduits." n'existe pas.");
			}
			dump($produits);
		
			return $this->render('FFFastBundle:Shop:view.html.twig', array(
				'produits' => $produits,
				'listGammes' => $listGammes,
				'panier' => $session->get('panier')
			));
	}
}
		

