<?php

namespace FF\FastBundle\Controller;
use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FF\FastBundle\Entity\Gammes;
use FF\FastBundle\Entity\Commentaire;
use FF\FastBundle\Form\GammesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ShopController extends Controller
{
	  public function accueilAction(Request $request)
    {         
				$session = $request->getSession();
		    if (!$session->has('panier')) $session->set('panier',array());
        		$panier = $session->get('panier');						
		
				$listGammes = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Gammes')
					->findAll();


        return $this->render('FFFastBundle:Shop:accueil.html.twig', array(
						'listGammes' => $listGammes,

				));
    }
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

			 $nbs = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNb();
			dump($nbs);
			dump($listGammes);
			 $nbt = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNbt();
						dump($nbt);

			  $nbPages = ceil(count($listProduits) / $nbPerPage);
			
				if ($page > $nbPages)
				{
					 throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Shop:index.html.twig', array(
						'listProduits' => $listProduits,
						'nbs'          => $nbs,
						'nbt'          => $nbt,
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
			dump($listProduits);
			$listGammes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Gammes')
				->findAll();
			
				 $gammes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Gammes')
				->findOneById($gamme);
			
			dump($gammes);
			dump($nbPerPage);
			$nbs = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNb();
			dump($nbs);
			dump($listGammes);
			 $nbt = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNbt();
						dump($nbt);
			$nbPages = ceil(count($listProduits) / $nbPerPage);
			
			if ($page > $nbPages)
			{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}
			 
			return $this->render('FFFastBundle:Shop:gamme.html.twig', array(
				'listProduits' => $listProduits,
				'nbs'          => $nbs,
				'nbt'          => $nbt,
				'listGammes' => $listGammes,
				'nbPages'         => $nbPages,
				'page'            => $page,	
				'gammes'            => $gammes,	
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
			$nbPerPage = 10;

			$listGammes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Gammes')
				->findAll()
				;
				$commentaires = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commentaire')
				->findByProduits($idProduits)
				;
		$nbs = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNb();
			dump($nbs);
			dump($listGammes);
			 $nbt = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNbt();
						dump($nbt);
			if (null === $produits) 
			{
				throw new NotFoundHttpException("Le Produit d'id ".$idProduits." n'existe pas.");
			}
			dump($produits);
		
			return $this->render('FFFastBundle:Shop:view.html.twig', array(
				'produits' => $produits,
				'listGammes' => $listGammes,
				'nbs'          => $nbs,
				'nbt'          => $nbt,
				'panier' => $session->get('panier'),
				'commentaires' => $commentaires,
			));
	}
	
	public function searchAction(Request $request,$page)
	{		
			$session = $request->getSession();
						$nbPerPage = 10;

			if (!$session->has('panier')) $session->set('panier',array());
				$panier = $session->get('panier');	
      if ($request->getMethod() == 'POST')
			{
				dump($request);
				$search = $request->get('search');
				dump($search);
				
				$em = $this->getDoctrine()->getManager();
        $listProduits = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getSearch($search,$page,$nbPerPage);
				dump($listProduits);
				$listGammes = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Gammes')
					->findAll();
							$nbs = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNb();
			dump($nbs);
			dump($listGammes);
			 $nbt = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Produits')
					->getNbt();
						dump($nbt);
	$gammes = array (
    'name' => 'Recherche',
);
				
				$nbPages = ceil(count($listProduits) / $nbPerPage);
			
				if ($page > $nbPages)
				{
					throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}

			} 
			else 
			{
				throw $this->createNotFoundException('La page n\'existe pas.');
			}
			return $this->render('FFFastBundle:Shop:gamme.html.twig', array(
				'listProduits' => $listProduits,
				'gammes'          => $gammes,
				'nbs'          => $nbs,
				'nbt'          => $nbt,				
				'listGammes' => $listGammes,
				'nbPages'         => $nbPages,
				'page'            => $page,	
				'panier' => $session->get('panier')
			));
	}
}
		

