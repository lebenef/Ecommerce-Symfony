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
					$session = $request->getSession();
					if (!$session->has('panier')) $session->set('panier', array());

					$em = $this->getDoctrine()->getManager();
					$produits = $em->getRepository('FFFastBundle:Produits')->findArray(array_keys($session->get('panier')));

					return $this->render('FFFastBundle:Cart:show.html.twig', array(
							'produits' => $produits,
							'panier' => $session->get('panier')
					));
			}

			public function addAction(Request $request, $idProduits)
			{
					$session = $request->getSession();

					if (!$session->has('panier')) $session->set('panier',array());
					$panier = $session->get('panier');

					if (array_key_exists($idProduits, $panier)) 
					{
							if ($request->query->get('qte') != null) $panier[$idProduits] = $request->query->get('qte');
							dump($request);
							$request->getSession()->getFlashBag()->add('success','Quantité modifié avec succès');
					}
					else 	
					{
							if ($request->query->get('qte') != null)
							{
									$panier[$idProduits] = $request->query->get('qte');
							}
							else
							{
									$panier[$idProduits] = 1;
							}

							$session->getFlashBag()->add('success','Article ajouté avec succès');
					}

					$session->set('panier',$panier);

					return $this->redirect($this->generateUrl('ff_fast_show'));
			}



			public function deleteAction(Request $request,$idProduits)
			{
					$session = $request->getSession();
					$panier = $session->get('panier');

					if (array_key_exists($idProduits, $panier))
					{
							unset($panier[$idProduits]);
							$session->set('panier',$panier);
							$this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
					}

					return $this->redirect($this->generateUrl('ff_fast_show')); 
			}

  

			public function clearAction(Request $request)
			{            		   
				$session = $request->getSession();
				$session->set('panier', array());

				return $this->redirect($this->generateUrl('ff_fast_show'));
			}

			public function PreCommandeAction(Request $request)
			{
					$session = $request->getSession();
					$panier = $session->get('panier');

					$em = $this->getDoctrine()->getManager();
					$user = $this->container->get('security.token_storage')->getToken()->getUser();
				 	dump($panier);
					dump($user);
					$produits = $this->getDoctrine()
							->getRepository('FFFastBundle:Produits')
							->findArray(array_keys($session->get('panier')));
					dump($produits);


					$commande = new Commande();
					$commande->setUser($user);
					dump($commande);

					foreach($produits as $produit)
					{
							dump($produit);
							$idProduits= $produit->getId();
							dump($idProduits);
							$nb = $panier[$idProduits];
							dump($nb);

								for ($i=0;$i<$nb;$i++)
								{            
										$commandeproduit = new CommandeProduit();
										$commande->addCommandeproduit($commandeproduit);
										$commandeproduit->setCommande($commande);
										$commandeproduit->setProduits($produit);
										$commandeproduit->setEtat('10');
										dump($commandeproduit);
								}
					}
					$em->persist($commande);
					$em->flush();

					$session->set('panier', array());
				
					return $this->redirect($this->generateUrl(''));
			}
		
	
			public function viewAction(Request $request)
			{
					if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) 
					{
									return $this->redirect($this->generateUrl('fos_user_security_login'));
					}

					$session = $request->getSession();
					$panier = $session->get('panier');

					$em = $this->getDoctrine()->getManager();
					$user = $this->container->get('security.token_storage')->getToken();
					dump($user);
					$produits = $this->getDoctrine()
							->getRepository('FFFastBundle:Produits')
							->findArray(array_keys($session->get('panier')));


					return $this->render('FFFastBundle:Cart:view.html.twig', array(
								'produits'  => $produits,
								'user'   => $user,
								'panier' => $session->get('panier'),

						));   
			}

			public function ListAction($page)
			{
					$user = $this->container->get('security.token_storage')->getToken()->getUser();
					dump($user);		 
				if ($page < 1) 
				{
						throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}		
				
				$nbPerPage = 10;
				$repository = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:Commande')
					->getCommandeUser($page, $nbPerPage,$user);
				
				$listCommandes = $repository;
				dump($listCommandes);

				$nbPages = ceil(count($listCommandes) / $nbPerPage);
				if ($page > $nbPages)
				{
							throw $this->createNotFoundException("La page ".$page." n'existe pas.");
				}

				return $this->render('FFFastBundle:Cart:list.html.twig', array(
					'listCommandes' => $listCommandes,
					'nbPages'         => $nbPages,
					'page'            => $page,				
				));
			}
  
	
			public function viewcommandeAction(Request $request, $id)
			{			
					dump($id);
					$repository = $this->getDoctrine()
						->getManager()
						->getRepository('FFFastBundle:Commande');
				
					$commande = $repository->find($id);
					$repository2 = $this->getDoctrine()
					->getManager()
					->getRepository('FFFastBundle:CommandeProduit');
				
					$commandeproduit = $repository2->findByCommande($id);

				if (null === $commande)
				{
						throw new NotFoundHttpException("La commande  d'id ".$id." n'existe pas.");
				}
				dump($commandeproduit);
				
			return $this->render('FFFastBundle:Cart:viewcommande.html.twig', array(
					'commande' => $commande,
					 'commandeproduit' => $commandeproduit,


				));
			}
}

		

