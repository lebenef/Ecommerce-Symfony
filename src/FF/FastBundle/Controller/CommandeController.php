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




class CommandeController extends Controller
{
    public function indexAction($page)
    {
    	if ($page < 1) 
			{
      		throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    	}					 			
			$nbPerPage = 10;

			$listCommandes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande')
				->getCommandea($page, $nbPerPage);

			$nbPages = ceil(count($listCommandes) / $nbPerPage);

			if ($page > $nbPages)
			{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}

			return $this->render('FFFastBundle:Commande:index.html.twig', array(
				'listCommandes' => $listCommandes,
				'nbPages'         => $nbPages,
				'page'            => $page,				
			));
    }
  
  
    public function viewAction(Request $request, $id)
    {			

			$repository = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande');
			$commande = $repository->find($id);
			
			if (null === $commande) 
			{
      		throw new NotFoundHttpException("La commande  d'id ".$id." n'existe pas.");
			}
			
			dump($commande);
			
      return $this->render('FFFastBundle:Commande:view.html.twig', array('commande' => $commande,));
    }
	
	
	  public function editAction($idCommande,Request $request )
    {
		dump($idCommande);
			
    $em = $this->getDoctrine()->getManager();		
    $commande = $em->getRepository('FFFastBundle:Commande')->find($idCommande);
			
		if (null === $commande) 
		{
			throw new NotFoundHttpException("La commande  d'id ".$id." n'existe pas.");
		}
				
		$etat = array('etat' => 'etat');
    $form = $this->createFormBuilder($etat)
							->setAction($this->generateUrl('ff_fast_editco'))
							->setMethod('POST')
							->add('etat',     ChoiceType::class , array(
							'choices' => array(
							'Validée'     => 0,
							'En cours de Préparation'     => 1,
							'Préparée'     => 2,
							'En cours de Livraison'     => 3,
							'Livrée'     => 4,

							), 
							))
							->add('save',      SubmitType::class)
							->getForm();
				
		dump($form);
		dump($commande);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
		{
				dump($request);
				$em = $this->getDoctrine()->getManager();
				$em->flush();
				$request->getSession()->getFlashBag()->add('notice', 'Commande bien modifiée.');
		}	
		return $this->render('FFFastBundle:Commande:edit.html.twig', array(
			'commande' => $commande,
			'form' =>  $form->createView(),
			
		));
					
	}
	
	
}
	


