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
    public function indexAction($page)
    {
								
		 
    	if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }					 			$nbPerPage = 10;

					$listProduits = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						->getProduits($page, $nbPerPage)
           ;
            $listGammes = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->findAll()
						;

			   $nbPages = ceil(count($listProduits) / $nbPerPage);
 			 if ($page > $nbPages)
			 {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Shop:index.html.twig', array(
					'listProduits' => $listProduits,
          'listGammes' => $listGammes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
				
    }
  
	    public function gammeAction($page, $gamme)
    {
				dump($gamme);
				dump($page);
								
		 
    	if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }					 			$nbPerPage = 10;

					$listProduits = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						->getProduitsByGamme($gamme,$page, $nbPerPage)
           ;
            $listGammes = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->findAll()
						;
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
					'page'            => $page,				));
				
    }
  
  
	
    public function viewAction(Request $request, $id)
      {			
		$nb = array('nb' => 'nb');
    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $form = $this->createFormBuilder($nb)
            ->setAction($this->generateUrl('ff_fast_addc'))
            ->setMethod('POST')
         	 ->add('nb',     ChoiceType::class , array(
            'choices' => array(
            '1'     => 1,
            '2'     => 2,
            '3'     => 3,
            '4'     => 4,
            '5'     => 5,
            '6'     => 6,
            '7'     => 7,
            '8'     => 8,
            '9'     => 9,
           '10'     => 10,

          ), 
						))
				 ->add('save',      SubmitType::class)
         ->getForm();
		     $form->handleRequest($request);

					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Produits')
						;
					$produits = $repository->find($id);
			
			     $listGammes = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Gammes')
						->findAll()
						;
				if (null === $produits) {
      throw new NotFoundHttpException("Le Produit d'id ".$id." n'existe pas.");
					}
						dump($produits);
      return $this->render('FFFastBundle:Shop:view.html.twig', array(
          'produits' => $produits,
				  'listGammes' => $listGammes,
				  'form' => $form->createView(),

        ));
    }
	
	
}
		

