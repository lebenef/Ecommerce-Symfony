<?php

namespace FF\FastBundle\Controller;
use FF\FastUser\Entity\User;
use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FF\FastBundle\Entity\Gammes;
use FF\FastBundle\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;




class CommentaireController extends Controller
{
    public function addAction(Request $request, $idProduits)
    {
 dump($idProduits);

   	 	$commentaire = new Commentaire();					
   		$form = $this->get('form.factory')->create(CommentaireType::class, $commentaire);
			$user = $this->getUser();

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits');
			
			$produits = $repository->find($idProduits);
				
				$commentaire->setProduits($produits);
				
			$commentaire->setUser($user);
					$em = $this->getDoctrine()->getManager();
					$em->persist($commentaire);

					$em->flush();
				
        	$request->getSession()->getFlashBag()->add('success', 'Commentaire bien enregistrée.');

        	return $this->redirectToRoute('ff_fast_views',array('idProduits' => $idProduits));
      }
    

			return $this->render('FFFastBundle:Commentaire:add.html.twig', array(
				'form' => $form->createView(),
				));
    }
	
	
}
	


