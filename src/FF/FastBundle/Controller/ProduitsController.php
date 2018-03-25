<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProduitsController extends Controller
{

    public function indexAction($page)
    {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}
								
		
    	if ($page < 1) 
			{
     		 throw $this->createNotFoundException("La page ".$page." n'existe pas.");
   	  }		
			 			$nbPerPage = 10;

			$repository = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Produits')
				->getProduits($page, $nbPerPage);
			
			$listProduits = $repository;
			
			$nbPages = ceil(count($listProduits) / $nbPerPage);
		 if ($page > $nbPages)
		 {
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		 }
			 
		return $this->render('FFFastBundle:Produits:index.html.twig', array(
			'listProduits' => $listProduits,
			'nbPages'         => $nbPages,
			'page'            => $page,				));
				
		}
	
    public function addAction(Request $request)
    {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}

	    $produits = new Produits();					
   		$form = $this->get('form.factory')->create(ProduitsType::class, $produits);

			
			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($produits);
				$em->flush();
				
        $request->getSession()->getFlashBag()->add('success', 'Produit bien enregistrée.');

        return $this->redirectToRoute('ff_fast_viewp', array('id' => $produits->getId()));
      }
			
			return $this->render('FFFastBundle:Produits:add.html.twig', array(
				'form' => $form->createView(),
				));
    }
	

    public function viewAction($id)
    {		
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}

			$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits');
			
			$produits = $repository->find($id);
			
		 if (null === $produits) 
		 {
      	throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
		 }
						
      return $this->render('FFFastBundle:Produits:view.html.twig', array(
          'produits' => $produits
        ));
    }


    public function editAction($id,Request $request )
    {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}
			$em = $this->getDoctrine()->getManager();		
			$produits = $em->getRepository('FFFastBundle:Produits')->find($id);
			
			if (null === $produits) 
			{
				throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
			}

   		$form = $this->get('form.factory')->create(ProduitsType::class, $produits);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->flush();

				
			$request->getSession()->getFlashBag()->add('success', 'Produit bien modifiée.');
		  return $this->redirectToRoute('ff_fast_viewp', array('id' => $produits->getId()));
					
				}
			
			
			
			
			        return $this->render('FFFastBundle:Produits:edit.html.twig', array(
					'produits'=> $produits,			
        	'form' => $form->createView(),
        	));

				
            
    }

	
	public function deleteAction(Request $request, $id)
  {
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}

			$em = $this->getDoctrine()->getManager();

			$produits = $em->getRepository('FFFastBundle:Produits')->find($id);

			if (null === $produits) 
			{
				throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
			}
		
			$form = $this->get('form.factory')->create();

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
			{
				$em->remove($produits);
				$em->flush();

				$request->getSession()->getFlashBag()->add('info', "Le produits a bien été supprimée.");

				return $this->redirectToRoute('ff_fast_homep');
			}

			return $this->render('FFFastBundle:Produits:delete.html.twig', array(
				'produits' => $produits,
				'form'   => $form->createView(),
			));
  }
}
