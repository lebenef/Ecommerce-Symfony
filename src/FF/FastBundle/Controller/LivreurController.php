<?php

namespace FF\FastBundle\Controller;
use FF\FastBundle\Entity\Commande;
use FF\FastBundle\Entity\CommandeProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FF\FastBundle\Entity\Gammes;
use FF\FastBundle\Form\GammesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class LivreurController extends Controller
{
    public function indexAction($page)
    {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_LIVREUR')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}    	
			
			if ($page < 1) 
			{
      		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    	}					 
			
			$nbPerPage = 10;

			$listCommandes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande')
				->getCommande($page, $nbPerPage);

			$nbPages = ceil(count($listCommandes) / $nbPerPage);

			if ($page > $nbPages)
			{
					throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		 	}
			 
			return $this->render('FFFastBundle:Livreur:index.html.twig', array(
				'listCommandes' => $listCommandes,
				'nbPages'         => $nbPages,
				'page'            => $page,				));
				
    }
	
	
	
	  public function etatAction($etat, $page)
    {
				if (!$this->get('security.authorization_checker')->isGranted('ROLE_LIVREUR')) 
				{
					throw new AccessDeniedException('Accès limité.');
				} 	

				dump($etat);
				dump($page);

				if ($page < 1) 
				{
						throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}			

				$nbPerPage = 10;

				$listCommandes = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Commande')
					-> getCommandeEtat($page, $nbPerPage, $etat);

				 $nbPages = ceil(count($listCommandes) / $nbPerPage);
			
				if ($page > $nbPages)
			 	{
     		 		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Livreur:etat.html.twig', array(
					'listCommandes' => $listCommandes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
				
    }
  

	
	

	
	    public function viewAction(Request $request, $id)
      {			
				if (!$this->get('security.authorization_checker')->isGranted('ROLE_LIVREUR')) 
				{
					throw new AccessDeniedException('Accès limité.');
				} 
				
				$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Commande');
				
				$commande = $repository->find($id);
			

				if (null === $commande) 
				{
      			throw new NotFoundHttpException("La commande  d'id ".$id." n'existe pas.");
				}
				
				dump($commande);
				
      	return $this->render('FFFastBundle:Livreur:view.html.twig', array(
          'commande' => $commande,));
    		}
	
	
		  public function editAction($idCommande,Request $request )
   	 {
				if (!$this->get('security.authorization_checker')->isGranted('ROLE_LIVREUR')) 
				{
					throw new AccessDeniedException('Accès limité.');
				} 
				
				$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Commande');
				
				$commande = $repository->find($idCommande);
				
				if (null === $commande) 
				{
      			throw new NotFoundHttpException("La commande  d'id ".$idCommande." n'existe pas.");
				}
				
				if ($commande->getEtat() == '2')
				{
								    $livreur = $this->container->get('security.token_storage')->getToken()->getUser();
					$commande->setLivreur($livreur);
										$em = $this->getDoctrine()->getManager();
										$em->flush();
					
						$test= $commande->getEtat();
            dump($test);

						$commande->setEtat('3');
						
						$em = $this->getDoctrine()->getManager();
						$em->flush();
									
						$repository = $this->getDoctrine()
							->getManager()
							->getRepository('FFFastBundle:CommandeProduit');
					
				
						dump($repository);
						$commandeproduit = $repository->findBy( array('commande' => $idCommande) );				
						dump($commandeproduit);		
									
						foreach($commandeproduit as $produits)
						{
								dump($produits);
 
							 	if($produits->getEtat() == '2')
							 	{
										$produits->setEtat('3');
										$em = $this->getDoctrine()->getManager();
										$em->flush();
							 	}
						 }
									
						}
				
						dump($idCommande);

    				$em = $this->getDoctrine()->getManager();		
    				$commande = $em->getRepository('FFFastBundle:Commande')->find($idCommande);
				
						$repository2 = $this->getDoctrine()
							->getManager()
							->getRepository('FFFastBundle:CommandeProduit');
						$commandeproduit = $repository2->findBy( array('commande' => $idCommande) );
						dump($commandeproduit);
						$etat = $commandeproduit;
				

						if (null === $commande) 
						{
							throw new NotFoundHttpException("La commande  d'id ".$id." n'existe pas.");
						}
				
						dump($commandeproduit);
				
						if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
						{
								dump($request);
								$em = $this->getDoctrine()->getManager();
								$em->flush();

								$request->getSession()->getFlashBag()->add('success', 'Commande bien modifiée.');
						}	
				
						return $this->render('FFFastBundle:Livreur:edit.html.twig', array(
								'commande' => $commande,
								'commandeproduit'  => $commandeproduit,
						));
				}
	
	
			 public function cpAction(Request $request, $idCommande)
			 {
						if (!$this->get('security.authorization_checker')->isGranted('ROLE_LIVREUR')) 
						{
							throw new AccessDeniedException('Accès limité.');
						} 					
				 		dump($idCommande);

						$em = $this->getDoctrine()->getManager();
						$repository = $em->getRepository('FFFastBundle:Commande');
						$cp = $repository->findOneBy(array('id' => $idCommande));
						$cp->setEtat('4');
				 
				 		$repository2 = $this->getDoctrine()
							->getManager()
							->getRepository('FFFastBundle:CommandeProduit');
					
				
						$commandeproduit = $repository2->findBy( array('commande' => $idCommande) );			
				 
				 		foreach($commandeproduit as $produits)
						{
								dump($produits);
 
										$produits->setEtat('4');
										$em = $this->getDoctrine()->getManager();
										$em->flush();
						 }
						$em->flush();
						$request->getSession()->getFlashBag()->add('success', 'Commande bien modifiée.');

						return $this->redirectToRoute('ff_fast_homel');
					}
 
   }

	

	


