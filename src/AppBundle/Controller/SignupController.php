<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class SignupController extends AbstractController
{
    /**
     * @Route("/register/", name="security_register")
     * @param Request $request
     * @param GuardAuthenticatorHandler $guard
     * @param \AppBundle\Security\LoginFormAuthenticator $authenticator
     * @param EntityManagerInterface $em
     * @return null | \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(
       Request $request,
       GuardAuthenticatorHandler $guard,
    \AppBundle\Security\LoginFormAuthenticator $authenticator,
     EntityManagerInterFace $em
   ) {
        /**
         * @var \AppBundle\Entity\Country | [] $countries
         * @var \AppBundle\Entity\Genre | [] $genres
         * @var \Symfony\Component\Form\Form $form
         */
        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $genres = $em->getRepository('AppBundle:Genre')->findAll();
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var \AppBundle\Entity\Accounts $user
             */
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getEmail());

            return $guard
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main'
                );
        }

        return $this->render('default/register.html.twig', array(
            'form' => $form->createView(),
            'countries'=> $countries,
            'genres'=> $genres
        ));
    }
}
