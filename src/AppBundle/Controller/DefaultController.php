<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Films;
use AppBundle\Entity\Comments;
use AppBundle\Form\CommentsType;
use AppBundle\Form\FilmsType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        return $this->redirectToRoute('film_listing');
    }

    /**
     * @Route("/films", name="film_listing")
     * @param \AppBundle\Pagination\PaginationFactory $paginator
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return null | \Symfony\Component\HttpFoundation\Response
     */
    public function listFilmAction(
        \AppBundle\Pagination\PaginationFactory $paginator,
        Request $request,
     EntityManagerInterFace $em
    ) {
        /**
         * @var \Doctrine\DBAL\Query\QueryBuilder $queryBuilder
         * @var \AppBundle\Pagination\PaginatedCollection $collection
         * @var \AppBundle\Entity\Country | [] $countries
         * @var \AppBundle\Entity\Genre | [] $genres
         */
        $queryBuilder = $em->getRepository('AppBundle:Films')
            ->getFilmLists();
        $collection = $paginator->createCollection($queryBuilder, $request, 'film_listing');
        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $genres = $em->getRepository('AppBundle:Genre')->findAll();
        return $this->render('default/list.html.twig', array('collection' => $collection,
            'countries'=> $countries,
            'genres'=> $genres));
    }



    /**
     * @Route("/films/create", name="films_new")
     * @Security("has_role('ROLE_USER')")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response |  \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newFilmAction(EntityManagerInterFace $em, Request $request)
    {
        /**
         * @var \AppBundle\Entity\Country | [] $countries
         * @var \AppBundle\Entity\Genre | [] $genres
         * @var Films $film
         * @var \Symfony\Component\Form\Form $form
         */
        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $genres = $em->getRepository('AppBundle:Genre')->findAll();
        $film = new Films();
        $form = $this->createForm(FilmsType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $film = $form->getData();
            $em->persist($film);
            $em->flush();
            $this->addFlash('success', 'New Film Added with name '.$film->getName());
            return $this->redirectToRoute('film_display', array('slug'=> $film->getSlug()));
        }
        return $this->render('default/new.html.twig', array('form'=>$form->createView(),
            'countries'=> $countries,
            'genres'=> $genres));
    }

    /**
     * @Route("/films/{slug}", name="film_display")
     * @ParamConverter("film", class="AppBundle:Films")
     * @param Request $request
     * @param Films $film
     * @param EntityManagerInterface $em
     * @return null | \Symfony\Component\HttpFoundation\Response
     */
    public function displayFilmAction(Request $request, Films $film, EntityManagerInterFace $em)
    {
        /**
         * @var \AppBundle\Entity\Country | [] $countries
         * @var \AppBundle\Entity\Genre | [] $genres
         * @var Comments $comment
         * @var \Symfony\Component\Form\Form $form
         */
        $countries = $em->getRepository('AppBundle:Country')->findAll();
        $genres = $em->getRepository('AppBundle:Genre')->findAll();
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setFilmId($film);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('Success', 'Your comment has been added');
        }
        return $this->render('default/show.html.twig', array('film'=> $film,
            'form' => $form->createView(),
            'countries'=> $countries,
            'genres'=> $genres));
    }

    /**
     * @Route("/api/films", name="api_film_listing")
     * @Method({"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return null | \Symfony\Component\HttpFoundation\Response
     * This endpoint returns rather oddly HTML, in order to
     * accelerate dev time of the test project
     */
    public function apiListFilmAction(
        \AppBundle\Pagination\PaginationFactory $paginator,
        Request $request,
     EntityManagerInterFace $em
    ) {
        /**
         * @var \Doctrine\DBAL\Query\QueryBuilder $queryBuilder
         * @var \AppBundle\Pagination\PaginatedCollection $collection
         * @var \AppBundle\Pagination\PaginationFactory $paginator
         */
        $queryBuilder = $em->getRepository('AppBundle:Films')
            ->getFilmLists();
        $collection = $paginator->createCollection($queryBuilder, $request, 'api_film_listing');
        return $this->render('default/api.html.twig', array('collection' => $collection,));
    }

    /**
     * @Route("api/films/create", name="api_films_new")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function apiNewFilmAction(EntityManagerInterFace $em, Request $request)
    {
        /**
         * @var Films $film
         * @var \Symfony\Component\Form\Form $form
         */
        $film = new Films();
        $form = $this->createForm(FilmsType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $film = $form->getData();
            $em->persist($film);
            $em->flush();
            $location = array(
                'location' => $this->generateUrl(
                    'api_films_manage',
                array('slug'=> $film->getSlug())
                ));
            return new JsonResponse($location, 204);
        }
        return new JsonResponse($form->createView(), 401);
    }

    /**
     * @Route("/api/films/{slug}", name="api_film_manage")
     * @ParamConverter("film", class="AppBundle:Films")
     * @Security("has_role('ROLE_USER')")
     * @Method({"PUT", "DELETE", "GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Films $film
     * @return JsonResponse
     */
    public function apiManageFilmAction(Request $request, EntityManagerInterFace $em, Films $film)
    {
        if ($request->getMethod() === 'GET') {
            /**
             * @var array $data
             */
            $data = $em->getRepository('AppBundle:Films')
                ->getFilmPage($film->getSlug());
            return new JsonResponse($data);
        } elseif ($request->getMethod() === 'DELETE') {
            $em->remove($film);
            $em->flush();
            return new JsonResponse(null, 204);
        } else {
            /**
             * @var \Symfony\Component\Form\Form $form
             */
            $form = $this->createForm(FilmsType::class, $film);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return new JsonResponse(null, 204);
            }
            return new JsonResponse($form->createView(), 401);
        }
    }
}
