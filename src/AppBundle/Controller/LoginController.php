<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\LoginForm;
use AppBundle\Form\Type\PasswordResetForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;

class LoginController extends AbstractController
{
    /**
       * @Route("/login", name="security_login")
       * @param EntityManagerInterface $em
       * @param AuthenticationUtils $authenticationUtils
       * @return null | \Symfony\Component\HttpFoundation\Response
       */
    public function loginAction(
        AuthenticationUtils $authenticationUtils,
     EntityManagerInterFace $em
    ) {
        /**
         * @var \AppBundle\Entity\Country | [] $countries
         * @var \AppBundle\Entity\Genre | [] $genres
         * @var \Symfony\Component\Form\Form $form
         * @var string | null $lastUsername
         * @var string | null $error
         */
        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $genres = $em->getRepository('AppBundle:Genre')->findAll();
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render(
            'default/login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
                'countries'=> $countries,
                'genres'=> $genres
            )
        );
    }

    /**
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}
