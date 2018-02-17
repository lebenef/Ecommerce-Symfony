<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Ingredients;
use FF\FastBundle\Form\IngredientsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class IngredientsController extends Controller
{
    public function indexAction()
    {
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Ingredients')
						;
					$listIngredients = $repository->findAll();
			

        return $this->render('FFFastBundle:Ingredients:index.html.twig', array('listIngredients' => $listIngredients) );
    }

    public function addAction(Request $request)
    {
   	 	$ingredients = new Ingredients();					
   		$form = $this->get('form.factory')->create(IngredientsType::class, $ingredients);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->persist($ingredients);
									$em->flush();

				
        $request->getSession()->getFlashBag()->add('notice', 'Ingredient bien enregistrée.');

        return $this->redirectToRoute('ff_fast_viewi', array('id' => $ingredients->getId()));
      }
    

        return $this->render('FFFastBundle:Ingredients:add.html.twig', array(
        	'form' => $form->createView(),
        	));
    }
	

    public function viewAction($id)
      {			
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Ingredients')
						;
					$ingredients = $repository->find($id);
			
			    if (null === $ingredients) {
      throw new NotFoundHttpException("L'ingredient d'id ".$id." n'existe pas.");
					}
						
      return $this->render('FFFastBundle:Ingredients:view.html.twig', array(
          'ingredients' => $ingredients
        ));
    }


    public function editAction($id,Request $request )
    {
    $em = $this->getDoctrine()->getManager();		
    $ingredients = $em->getRepository('FFFastBundle:Ingredients')->find($id);
			
			if (null === $ingredients) 
			{
				throw new NotFoundHttpException("L'Ingredient d'id ".$id." n'existe pas.");
			}

   		$form = $this->get('form.factory')->create(IngredientsType::class, $ingredients);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->flush();

				
			$request->getSession()->getFlashBag()->add('notice', 'Ingredient bien modifiée.');
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
    $em = $this->getDoctrine()->getManager();

    $ingredients = $em->getRepository('FFFastBundle:Ingredients')->find($id);

    if (null === $ingredients) {
      throw new NotFoundHttpException("La Ingredients d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
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
