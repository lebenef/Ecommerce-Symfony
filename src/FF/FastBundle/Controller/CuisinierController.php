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




class CuisinierController extends Controller
{
    public function indexAction($page)
    {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUISINIER')) 
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
			 
        return $this->render('FFFastBundle:Cuisinier:index.html.twig', array(
					'listCommandes' => $listCommandes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
				
    }
	
	
	
	  public function etatAction($etat, $page)
    {
				if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUISINIER')) 
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
			 
        return $this->render('FFFastBundle:Cuisinier:etat.html.twig', array(
					'listCommandes' => $listCommandes,
					'nbPages'         => $nbPages,
					'etat'           => $etat,
					'page'            => $page,				));
				
    }
  

	
	

	
	    public function viewAction(Request $request, $id)
      {			
					if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUISINIER')) 
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
				
					$test= $commande->getEtat();
				 	dump($test);
					$commande->setEtat('1');

				  $em = $this->getDoctrine()->getManager();
          $em->flush();
				
					dump($commande);
				
     			 return $this->render('FFFastBundle:Cuisinier:view.html.twig', array(
        		  'commande' => $commande,));
  	  }
	
	
	  public function editAction($idCommande,Request $request )
    {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUISINIER')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}
		  dump($idCommande);
				
			$repository = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande');
				
				
			$commande = $repository->find($idCommande);
				
			if (null === $commande)
			{
					throw new NotFoundHttpException("La commande  d'id ".$idCommande." n'existe pas.");
			}

			if ($commande->getEtat() == '0')
			{
					$test= $commande->getEtat();
					dump($test);

					$commande->setEtat('1');

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

							 if($produits->getEtat() == '0')
						 	{
									$produits->setEtat('1');
									$em = $this->getDoctrine()->getManager();
									$em->flush();
							}
					 }
			}


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
				


			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
					dump($request);
					$em = $this->getDoctrine()->getManager();
					$em->flush();
				
					$request->getSession()->getFlashBag()->add('notice', 'Commande bien modifiée.');
			}	
			return $this->render('FFFastBundle:Cuisinier:edit.html.twig', array(
				'commande' => $commande,
				'commandeproduit'  => $commandeproduit,
			));
					
		}
	
	
	   public function cpAction(Request $request, $idCommandeProduit)
   {
		 
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUISINIER')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}
			 
      dump($idCommandeProduit);

			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('FFFastBundle:CommandeProduit');
			$cp = $repository->findOneBy(array('id' => $idCommandeProduit));
			$etat = $request->request->get('form')['etat'];
			dump($etat);
			$cp->setEtat('2');
			$idCommande=$cp->getCommande()->getId();
			dump($idCommande);
			 
			$em->flush();
		 $request->getSession()->getFlashBag()->add('success', 'Commande bien modifiée.');
			 
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('FFFastBundle:CommandeProduit');
			$commandeproduit =$repository->findBy(array('id' => $idCommandeProduit));
			$bool =true;

			 foreach($commandeproduit as $produits)
			 {
					if($produits->getEtat() == '1' )
					{						
							$bool = false;
					}
					
			 }
			 
			 if($bool == true)
			 {
				 
          $em = $this->getDoctrine()->getManager();
          $repository = $em->getRepository('FFFastBundle:Commande');
          # select wanted item from shipping table to edit it
          $commande = $repository->find($idCommande);
				  $commande->setEtat('2');
				 
				  $em->flush();
				 
				 	return $this->redirectToRoute('ff_fast_homecu');

			 }
      
    		return $this->redirectToRoute('ff_fast_editcu',['idCommande' => $idCommande,]);
   }	
}
	


