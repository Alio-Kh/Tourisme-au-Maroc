<?php

namespace App\Controller;

use App\Entity\Resto;
use App\Entity\RestoLike;
use App\Form\Resto3Type;
use App\Repository\RestoLikeRepository;
use App\Repository\RestoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resto")
 */
class RestoController extends AbstractController
{
    /**
     * @Route("/", name="resto_index", methods={"GET"})
     */
    public function index(RestoRepository $restoRepository): Response
    {
        return $this->render('resto/index.html.twig', [
            'restos' => $restoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="resto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resto = new Resto();
        $form = $this->createForm(Resto3Type::class, $resto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resto);
            $entityManager->flush();

            return $this->redirectToRoute('resto_index');
        }

        return $this->render('resto/new.html.twig', [
            'resto' => $resto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resto_show", methods={"GET"})
     */
    public function show(Resto $resto): Response
    {
        return $this->render('resto/show.html.twig', [
            'resto' => $resto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resto $resto): Response
    {
        $form = $this->createForm(Resto3Type::class, $resto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resto_index');
        }

        return $this->render('resto/edit.html.twig', [
            'resto' => $resto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resto_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resto $resto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resto_index');
    }
     /**
     * @Route("/{id}/like", name="resto_like")
     */
    public function like(Resto $resto, RestoLikeRepository $restoLikeRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['code' => 403, 'message' => 'Unthauthorized'], 403);
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($resto->isLikedByUser($user)) {

            $like = $restoLikeRepository->findOneBy(['resto' => $resto, 'user' => $user]);
            $entityManager->remove($like);
            $entityManager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimer ',
                'likes' => $restoLikeRepository->count(['resto' => $resto])
            ], 200);
        }
        $like = new RestoLike();
        $like->setResto($resto);
        $like->setUser($user);
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouter ',
            'likes' => $restoLikeRepository->count(['resto' => $resto])
        ], 200);
    }
}
