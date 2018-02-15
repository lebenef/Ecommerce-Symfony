<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Gammes;
use FF\FastBundle\Form\GammesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class GammesController extends Controller
{
    public function indexAction()
    {
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						;
					$listGammes = $repository->findAll();
			

        return $this->render('FFFastBundle:Gammes:index.html.twig', array('listGammes' => $listGammes) );
    }

    public function addAction(Request $request)
    {
   	 	$gammes = new Gammes();					
   		$form = $this->get('form.factory')->create(GammesType::class, $gammes);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->persist($gammes);
									$em->flush();

				
        $request->getSession()->getFlashBag()->add('notice', 'Gamme bien enregistrée.');

        return $this->redirectToRoute('ff_fast_view', array('id' => $gammes->getId()));
      }
    

        return $this->render('FFFastBundle:Gammes:add.html.twig', array(
        	'form' => $form->createView(),
        	));
    }
	

    public function viewAction($id)
      {			
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						;
					$gammes = $repository->find($id);
			
			    if (null === $gammes) {
      throw new NotFoundHttpException("La gamme d'id ".$id." n'existe pas.");
					}
						
      return $this->render('FFFastBundle:Gammes:view.html.twig', array(
          'gammes' => $gammes
        ));
    }


    public function editAction($id,Request $request )
    {
    $em = $this->getDoctrine()->getManager();		
    $gammes = $em->getRepository('FFFastBundle:Gammes')->find($id);
			
			if (null === $gammes) 
			{
				throw new NotFoundHttpException("La gamme d'id ".$id." n'existe pas.");
			}

   		$form = $this->get('form.factory')->create(GammesType::class, $gammes);

				if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
									$em = $this->getDoctrine()->getManager();
									$em->flush();

				
			$request->getSession()->getFlashBag()->add('notice', 'Gamme bien modifiée.');
		  return $this->redirectToRoute('ff_fast_view', array('id' => $gammes->getId()));
					
				}
			
			
			
			
			        return $this->render('FFFastBundle:Gammes:edit.html.twig', array(
					'gammes'=> $gammes,			
        	'form' => $form->createView(),
        	));

      dump($gammes);
				
            
    }

	
	public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $gammes = $em->getRepository('FFFastBundle:Gammes')->find($id);

    if (null === $gammes) {
      throw new NotFoundHttpException("La Gamme d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($gammes);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "La Gamme a bien été supprimée.");

      return $this->redirectToRoute('ff_fast_home');
    }
    
    return $this->render('FFFastBundle:Gammes:delete.html.twig', array(
      'gammes' => $gammes,
      'form'   => $form->createView(),
    ));
  }
}
