<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Ingredients;
use FF\FastBundle\Form\IngredientsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class IngredientsController extends Controller
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
						->getRepository('FFFastBundle:Ingredients')
			      ->getIngredients($page, $nbPerPage)
						;
			$listIngredients = $repository;
			
      $nbPages = ceil(count($listIngredients) / $nbPerPage);
			
 		  if ($page > $nbPages)
			{
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");	
	    }
			
			return $this->render('FFFastBundle:Ingredients:index.html.twig', array(
				'listIngredients' => $listIngredients,
				'nbPages'         => $nbPages,
				'page'            => $page,
			));
    }
		

	
    public function addAction(Request $request)
    {
		  if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
      throw new AccessDeniedException('Accès limité.');
      }			

   	 	$ingredients = new Ingredients();					
   		$form = $this->get('form.factory')->create(IngredientsType::class, $ingredients);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
					$em = $this->getDoctrine()->getManager();
					$em->persist($ingredients);
					$em->flush();
				
        	$request->getSession()->getFlashBag()->add('success', 'Ingredient bien enregistrée.');

        	return $this->redirectToRoute('ff_fast_viewi', array('id' => $ingredients->getId()));
      }
    

			return $this->render('FFFastBundle:Ingredients:add.html.twig', array(
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
					->getRepository('FFFastBundle:Ingredients')
					;
				$ingredients = $repository->find($id);
			
			  if (null === $ingredients)
				{
    		  throw new NotFoundHttpException("L'ingredient d'id ".$id." n'existe pas.");
				}
						
				return $this->render('FFFastBundle:Ingredients:view.html.twig', array(
						'ingredients' => $ingredients
					));
  	  }


    public function editAction($id,Request $request )
    {

			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
      throw new AccessDeniedException('Accès limité.');
      }
			$em = $this->getDoctrine()->getManager();		
			$ingredients = $em->getRepository('FFFastBundle:Ingredients')->find($id);

			if (null === $ingredients) 
			{
				throw new NotFoundHttpException("L'Ingredient d'id ".$id." n'existe pas.");
			}

			$form = $this->get('form.factory')->create(IngredientsType::class, $ingredients);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
					$em = $this->getDoctrine()->getManager();
					$em->flush();


					$request->getSession()->getFlashBag()->add('success', 'Ingredient bien modifiée.');
					return $this->redirectToRoute('ff_fast_viewi', array('id' => $ingredients->getId()));
					
			}
			
			return $this->render('FFFastBundle:Ingredients:edit.html.twig', array(
			'ingredients'=> $ingredients,			
			'form' => $form->createView(),
			));

      dump($ingredients);
				            
    }

	
	public function deleteAction(Request $request, $id)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
		{
			throw new AccessDeniedException('Accès limité.');
		}
    $em = $this->getDoctrine()->getManager();

    $ingredients = $em->getRepository('FFFastBundle:Ingredients')->find($id);

    if (null === $ingredients) 
		{
      throw new NotFoundHttpException("La Ingredients d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
		{
      $em->remove($ingredients);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'Ingredient a bien été supprimée.");

      return $this->redirectToRoute('ff_fast_homei');
    }
    
			return $this->render('FFFastBundle:Ingredients:delete.html.twig', array(
				'ingredients' => $ingredients,
				'form'   => $form->createView(),
			));
  	}
}
