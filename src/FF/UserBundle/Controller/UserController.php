<?php

namespace FF\UserBundle\Controller;

use FF\UserBundle\Entity\User;
use FF\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
class UserController extends Controller
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
					->getRepository('FFUserBundle:User')
					->getUser($page, $nbPerPage);

		$listUser = $repository;

		$nbPages = ceil(count($listUser) / $nbPerPage);

		if ($page > $nbPages) 
		{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");

		}
			return $this->render('FFUserBundle:User:index.html.twig', array(
				'listUser' => $listUser,
				'nbPages'         => $nbPages,
				'page'            => $page,
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
					->getRepository('FFUserBundle:User');

				$user = $repository->find($id);

				return $this->render('FFUserBundle:User:view.html.twig', array(
				 'user' => $user,
			 ));
		 }

	  public function editAction($id,Request $request )
    {
				
			if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
			{
				throw new AccessDeniedException('Accès limité.');
			}
			
			$em = $this->getDoctrine()->getManager();		
			$user = $em->getRepository('FFUserBundle:User')->find($id);
			
			if (null === $user) 
			{
				throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
			}

   		$form = $this->get('form.factory')->create(UserType::class, $user);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
					$em = $this->getDoctrine()->getManager();
					$em->flush();
				
					$request->getSession()->getFlashBag()->add('success', 'Utilisateur mis à jour.');
				
		  return $this->redirectToRoute('ff_user_view', array('id' => $user->getId()));
					
		   }
			
			
			
			
			return $this->render('FFUserBundle:User:edit.html.twig', array(
			'user'=> $user,			
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
			$user = $em->getRepository('FFUserBundle:User')->find($id);

    	if (null === $user)
			{
      	throw new NotFoundHttpException("L' utilisateur d'id ".$id." n'existe pas.");
    	}

 	   $form = $this->get('form.factory')->create();

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
			{
				$em->remove($user);
				$em->flush();

				$request->getSession()->getFlashBag()->add('success', "L'Utilisateur a bien été supprimée.");

				return $this->redirectToRoute('ff_user_home');
			}
    
    	return $this->render('FFUserBundle:User:delete.html.twig', array(
				'user' => $user,
				'form'   => $form->createView(),
    	));
 		 }
	
	  public function registrationAction(Request $request)
  {
 /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                /*****************************************************
                 * Add new functionality (e.g. log the registration) *
                 *****************************************************/
                $this->container->get('logger')->info(
                    sprintf("New user registration: %s", $user)
                );

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('FFUserBundle:User:registration.html.twig', array(
            'form' => $form->createView(),
        ));
  }

}