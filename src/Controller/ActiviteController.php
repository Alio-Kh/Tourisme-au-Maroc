<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\ActiviteLike;
use App\Form\Activite2Type;
use App\Repository\ActiviteLikeRepository;
use App\Repository\ActiviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activite")
 */
class ActiviteController extends AbstractController
{
    /**
     * @Route("/", name="activite_index", methods={"GET"})
     */
    public function index(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="activite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activite = new Activite();
        $form = $this->createForm(Activite2Type::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('activite_index');
        }

        return $this->render('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_show", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activite $activite): Response
    {
        $form = $this->createForm(Activite2Type::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activite_index');
        }

        return $this->render('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activite $activite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activite_index');
    }

     /**
     * @Route("/{id}/like", name="activite_like")
     */
    public function like(Activite $activite,ActiviteLikeRepository $activiteLikeRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['code' => 403, 'message' => 'Unthauthorized'], 403);
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($activite->isLikedByUser($user)) {

            $like = $activiteLikeRepository->findOneBy(['activite' => $activite, 'user' => $user]);
            $entityManager->remove($like);
            $entityManager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimer ',
                'likes' => $activiteLikeRepository->count(['activite' => $activite])
            ], 200);
        }
        $like = new ActiviteLike();
        $like->setActivite($activite);
        $like->setUser($user);
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouter ',
            'likes' => $activiteLikeRepository->count(['activite' => $activite])
        ], 200);
    }
}
