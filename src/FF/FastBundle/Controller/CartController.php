<?php

namespace FF\FastBundle\Controller;

use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Entity\Cart;
use FF\FastBundle\Entity\Shipping;
use FF\UserBundle\Entity\User;
use FF\FastBundle\Entity\Commande;
use FF\FastBundle\Entity\CommandeProduit;
use FF\FastBundle\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FF\FastBundle\Entity\Gammes;
use FF\FastBundle\Form\GammesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{

    public function showAction(Request $request)
    {
		$vide = false;
			
			$formsView = array();
			
    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    

        # Get object from doctrine manager
        $em = $this->getDoctrine()->getManager();
        # Get logged user then get his ['id']
        $user = $this->container->get('security.token_storage')->getToken();
			dump($user);
        /** Check IF user have exist cart  **/
        # select cart from database where user id equal to cureent logged user using [ findByUser() ]
        $user_cart = $this->getDoctrine()
            ->getRepository('FFFastBundle:Cart')
            ->findByUser($user);
       if ( sizeof($user_cart) != 0)
       {
            # Then select all user cart products to display it to user
            $user_products = $this->getDoctrine()
                ->getRepository('FFFastBundle:Shipping')
                ->findBy( array('cart' => $user_cart[0]->getId()) );
            # pass selected products to the twig page to show them
				 $test= false;
				 
				 foreach($user_products as $product)
				 {
					 $product->setView($this->createFormBuilder()
            ->setAction($this->generateUrl('ff_fast_editc'))
            ->setMethod('POST')
            ->add('nb', NumberType::class, array(
						'attr' => array(
								'min' => 1,
								'max' => 50
    )  ))        
				    ->add('Modifier',      SubmitType::class)
         ->getForm()->createView());
				 }
				 
				 dump($user_products);
           return $this->render('FFFastBundle:Cart:show.html.twig', array(
              'products'  => $user_products,
              'cart_data' => $user_cart[0],
						 	 'forms' => $formsView,
               					 'vide' => $vide,

          ));
        }
		
       //return new Response(''. $user_products[0]->getProduct()->getPrice() );
       # pass selected products to the twig page to show them
			$vide = true;
         return $this->render('FFFastBundle:Cart:show.html.twig', array(
					 'vide' => $vide,
				 ));
    }

   public function addAction(Request $request, $productId)
   {
      $nb=1;	
		 dump($request);
						if ($request->isMethod('POST')){
								$nb = $request->request->get('form')['nb'];
									 dump($nb);

    // On ajoute les champs de l'entité que l'on veut à notre formulair
						}
      # First of all check if user logged in or not by using FOSUSERBUNDLE
      #    authorization_checker
      # if user logged in so add the selected product to his cart and redirect user to products page
      # else redirect user to login page to login first or create a new account
      $securityContext = $this->container->get('security.authorization_checker');
      # If user logged in
   
          # Get object from doctrine manager
          $em = $this->getDoctrine()->getManager();
          # Get logged user then get his ['id']
          $user = $this->container->get('security.token_storage')->getToken();
          # for any case wewill need to select product so select it first
          # select specific product which have passed id using ['find(passedID)']
          $product = $this->getDoctrine()
                        ->getRepository('FFFastBundle:Produits')
                        ->find($productId);
          /** Check IF user have exist cart  **/
          # select cart from database where user id equal to cureent logged user using [ findByUser() ]
				dump($user);
								dump($product);
          $exsit_cart = $this->getDoctrine()
              ->getRepository('FFFastBundle:Cart')
              ->findByUser($user);

												dump($exsit_cart);

            # if there's no cart to this user create a new one
            if ( !$exsit_cart )
            {
                # defince cart object
                $cart = new Cart();
                # set user whose own this cart
                $cart->setUser($user);
                
                # set initail total price for cart which equal to product price
                $cart->setTotalPrice($product->getPrice() * $nb);
                # persist all cart data to can use it in create shipping object
                $em->persist($cart);
                # flush it
                $em->flush();
                # create shipping object
                $ship = new Shipping();
                # set all its data quantity initail equal to 1 and passed product and cart created
                $ship->setQuantity($nb);
                $ship->setProduits($product);
                $ship->setCart($cart);
                # persist it and flush doctrine to save it
                $em->persist($ship);
                $em->flush();
            }
            # if user have one so just add new item price to cart price and add it to shipping
            else
            {
                # Get cart from retrived object
                $cart = $exsit_cart[0];
                
                # set initail total price for cart which equal to product price
                $cart->setTotalPrice($cart->getTotalPrice() + $product->getPrice() * $nb);
                # persist all cart data to can use it in create shipping object
                $em->persist($cart);
                # flush it
                $em->flush();
                # create shipping object
							
							
							 $exsit_ship = $this->getDoctrine()
              ->getRepository('FFFastBundle:Shipping')
              ->findBy(array('produits' => $productId, 'cart' => $cart));

							dump($exsit_ship);
							if($exsit_ship)
							{
								dump($exsit_ship);
								$qu = $exsit_ship[0] ->getQuantity();
								dump($qu);
								$exsit_ship[0]->setQuantity($qu + $nb);
																	dump($exsit_ship);
								 
							 $em->persist($exsit_ship[0]);
                $em->flush();
    								return $this->redirectToRoute('ff_fast_show');

							}

							else
							{
                $ship = new Shipping();
                # set all its data quantity initail equal to 1 and passed product and cart created
                $ship->setQuantity($nb);
                $ship->setProduits($product);
                $ship->setCart($cart);
                # persist it and flush doctrine to save it
                $em->persist($ship);
                $em->flush();
							}
							
							    				return $this->redirectToRoute('ff_fast_show');

            }
          //return new Response('user id  '.$product->getId());

		 
		    return $this->render('FFFastBundle:Cart:view.html.twig', array(
        	'form' => $form->createView(),
        	));
   }

   public function deleteAction($idProduits, $idCart)
   {
		 
      # get an object from doctrine db and get Shipping Entity to work on it
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('FFFastBundle:Shipping');
      # select wanted item from shipping table to delete it
      $ship = $repository->findOneBy(array('produits' => $idProduits, 'cart' => $idCart));
			
      # Calculate the new total price for cart by subtract deleted item price from total one
       $final_price = $ship->getCart()->getTotalPrice() - ($ship->getProduits()->getPrice() * $ship->getQuantity());
       # update the total price of cart
       $ship->getCart()->setTotalPrice($final_price); 
       # Remove item from db
      $em->remove($ship);
      $em->flush();
		 if($final_price <= 0)
    		return $this->redirectToRoute('ff_fast_show');
   }

   public function editAction(Request $request, $idProduits, $idCart)
   {
		 

                   dump($idProduits);
									 dump($idCart);
      # in the start check if user edit field and click on button
      if ( $request->getMethod() === 'POST' )
      {
				
          $em = $this->getDoctrine()->getManager();
          $repository = $em->getRepository('FFFastBundle:Shipping');
          # select wanted item from shipping table to edit it
          $ship = $repository->findOneBy(array('produits' => $idProduits, 'cart' => $idCart));
				
          # read data from quantity field
				  $last_quantity = $ship-> getQuantity();
				  $last_price = $ship-> getProduits() ->getPrice() * $last_quantity;
						dump($last_price);
				    dump($last_quantity);
				
          $new_quantity = $request->request->get('form')['nb'];
				  dump($new_quantity);
				
				  $new_quantity = $new_quantity;
          # get oject from doctrine manager to mange operation

        # check if new quantity less than old one so subtract total price
          # otherwise, add to it
         
            # edit selected item quantity
            $ship->setQuantity($new_quantity);
            # Calculate the new total price for cart by sum added item price to total one
            $final_price = $ship->getCart()->getTotalPrice() + $ship->getProduits()->getPrice() * $new_quantity - $last_price;
            # update the total price of cart
            $ship->getCart()->setTotalPrice($final_price); 

          $em->flush();
      }
      //return new Response(''. $new_quantity );
    		return $this->redirectToRoute('ff_fast_show');
   }

   public function clearAction($idCart)
   {
      # get an object from doctrine db and get Shipping Entity to work on it
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('FFFastBundle:Shipping');
      # select wanted item from shipping table to delete it
      $ship = $repository->findBy(array('cart' => $idCart));
      # Fetch all them using foeach loop and delete them
      foreach ($ship as $one_prod)
      {
           # Remove item from db
          $em->remove($one_prod);
          $em->flush();     
      }
      $cart_repository = $em->getRepository('FFFastBundle:Cart');
      $one_cart = $cart_repository->findOneById($idCart);
      $em->remove($one_cart);
      $em->flush();
      return $this->redirect($this->generateUrl('ff_fast_show'));
   }

	public function CommandeAction(Request $request, $idCart)
    {
          $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
       
      $repository = $em->getRepository('FFFastBundle:Shipping');
      $ship = $repository->findBy(array('cart' => $idCart));
        dump($user);
            $commande = new Commande();
          $commande->setUser($user);
         dump($ship);
                 dump($commande);
 
       
        foreach($ship as $value)
        {
            dump($value);
            $nb = $value->getQuantity();
            $produit = $value->getProduits();
                dump($nb);
                dump($produit);
            for ($i=0;$i<$nb;$i++)
      {            
 
 
          $commandeproduit = new CommandeProduit();
        $commande->addCommandeproduit($commandeproduit);
          $commandeproduit->setCommande($commande);
        $commandeproduit->setProduits($produit);
                dump($commandeproduit);
            }
        }
          $em->persist($commande);
          $em->flush();
		
		 dump($idCart);
		 $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('FFFastBundle:Shipping');
      # select wanted item from shipping table to delete it
      $ship = $repository->findBy(array('cart' => $idCart));
      # Fetch all them using foeach loop and delete them
      foreach ($ship as $one_prod)
      {
           # Remove item from db
          $em->remove($one_prod);
          $em->flush();     
      }
      $cart_repository = $em->getRepository('FFFastBundle:Cart');
      $one_cart = $cart_repository->findOneById($idCart);
      $em->remove($one_cart);
      $em->flush();
		
              return $this->redirect($this->generateUrl(''));
 
       
    }
		
	
	   public function viewAction(Request $request)
    {
			
			
    

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken();
			dump($user);
        $user_cart = $this->getDoctrine()
            ->getRepository('FFFastBundle:Cart')
            ->findByUser($user);
      
            # Then select all user cart products to display it to user
            $user_products = $this->getDoctrine()
                ->getRepository('FFFastBundle:Shipping')
                ->findBy( array('cart' => $user_cart[0]->getId()) );
            # pass selected products to the twig page to show them
				 

				 
				 dump($user_products);
           return $this->render('FFFastBundle:Cart:view.html.twig', array(
              'products'  => $user_products,
              'cart_data' => $user_cart[0],
						  'user'   => $user,

          ));
        
	}
	
	    public function ListAction($page)
    {
					
				$user = $this->container->get('security.token_storage')->getToken()->getUser();
	dump($user);		 
    	if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }					 			$nbPerPage = 10;

					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Commande')
					  ->getCommandeUser($page, $nbPerPage,$user)

           ;
			 $listCommandes = $repository;
								dump($listCommandes);

				
           ;

			   $nbPages = ceil(count($listCommandes) / $nbPerPage);
 			 if ($page > $nbPages)
			 {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}
			 
        return $this->render('FFFastBundle:Cart:list.html.twig', array(
					'listCommandes' => $listCommandes,
					'nbPages'         => $nbPages,
					'page'            => $page,				));
				
    }
  

	}

		

