<?php
namespace FF\CoreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use FF\FastBundle\Entity\Commande;
use FF\FastBundle\Entity\Commentaire;
use Symfony\Component\Validator\Constraints\Date;

class CoreController extends Controller
{
  // La page d'accueil

  // La page de contact
  public function contactAction(Request $request)
  {
    // On récupère la session depuis la requête, en argument du contrôleur
    $session = $request->getSession();
    // Et on définit notre message
    $session->getFlashBag()->add('info', 'La page de contact n’est pas encore disponible, merci de revenir plus tard.');
    // Enfin, on redirige simplement vers la page d'accueil
    return new RedirectResponse($this->get('router')->generate('ff_core_home'));
    // Les méthodes raccourcies $this->redirect($this->generateUrl('oc_core_home')); sont parfaitement valables
  }
  
    public function indexAction()
  {
      $listCommandes = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') ; 
			$listCommentaires = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commentaire') ; 
      $date = new \DateTime('now');
      $datetemp = $date;
        
      $date1= $date->modify('-7 day');
      $date = new \DateTime('now');
      $date2 =$date->modify('-6 day');
      $date = new \DateTime('now');

      $date3 =$date->modify('-5 day');
      $date = new \DateTime('now');

      $date4 =$date->modify('-4 day');
      $date = new \DateTime('now');

      $date5 =$date->modify('-3 day');
      $date = new \DateTime('now');

      $date6 =$date->modify('-2 day');
      $date = new \DateTime('now');

      $date7 =$date->modify('-1 day');
       
      
      $value1 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date1)
        ;     
      
      $value2 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date2)
        ;   
      $value3 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date3)
        ;      
      $value4 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date4)
        ;       
      $value5 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date5)
        ;      
      $value6 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date6)
        ; 
      $value7 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date7)
        ; 
      $date = new \DateTime('now');
			  $commande = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDate($date)
        ; 
			 $commande2 = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commande') 
        ->getbyDatea($date)
        ; 
				$price = 0;
			
			foreach($commande2 as $com)
			{
				$price = $price + $com->getPrice($com);
			}
			$listCommentaires = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commentaire') 
        ->getbyDate($date);
				
			return $this->render('FFCoreBundle:Core:index.html.twig', array(
				'listCommandes' => $listCommandes,
				'listCommentaires' => $listCommentaires,
        'commande'          => $commande,
        'price'      => $price,
        'date1'          => $date1,
        'date2'          => $date2,
        'date3'          => $date3,
        'date4'          => $date4,
        'date5'          => $date5,
        'date6'          => $date6,
        'date7'          => $date7,
        'value1'          => $value1,
        'value2'          => $value2,
        'value3'          => $value3,
        'value4'          => $value4,
        'value5'          => $value5,
        'value6'          => $value6,
        'value7'          => $value7,			));      
  }
	
	
	   public function commentaireAction()
  {

			$commentaires = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commentaire') 
								->findAll()
; 
      $date = new \DateTime('now');
       
      
     
			$commentaires = $this->getDoctrine()
				->getManager()
				->getRepository('FFFastBundle:Commentaire')
        ->getbyDatenc($date);
				
			return $this->render('FFCoreBundle:Core:commentaire.html.twig', array(

				'commentaires' => $commentaires,
		));      
  }
}


