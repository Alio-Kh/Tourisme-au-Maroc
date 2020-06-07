<?php

namespace App\Controller;

use App\Entity\Camping;
use App\Entity\CampingLike;
use App\Form\Camping2Type;
use App\Repository\CampingLikeRepository;
use App\Repository\CampingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/camping")
 */
class CampingController extends AbstractController
{
    /**
     * @Route("/", name="camping_index", methods={"GET"})
     */
    public function index(CampingRepository $campingRepository): Response
    {
        return $this->render('camping/index.html.twig', [
            'campings' => $campingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="camping_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $camping = new Camping();
        $form = $this->createForm(Camping2Type::class, $camping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($camping);
            $entityManager->flush();

            return $this->redirectToRoute('camping_index');
        }

        return $this->render('camping/new.html.twig', [
            'camping' => $camping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="camping_show", methods={"GET"})
     */
    public function show(Camping $camping): Response
    {
        return $this->render('camping/show.html.twig', [
            'camping' => $camping,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="camping_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Camping $camping): Response
    {
        $form = $this->createForm(Camping2Type::class, $camping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('camping_index');
        }

        return $this->render('camping/edit.html.twig', [
            'camping' => $camping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="camping_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Camping $camping): Response
    {
        if ($this->isCsrfTokenValid('delete'.$camping->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($camping);
            $entityManager->flush();
        }

        return $this->redirectToRoute('camping_index');
    }

     /**
     * @Route("/{id}/like", name="camping_like")
     */
    public function like(Camping $camping, CampingLikeRepository $campinglLikeRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['code' => 403, 'message' => 'Unthauthorized'], 403);
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($camping->isLikedByUser($user)) {

            $like = $campinglLikeRepository->findOneBy(['camping' => $camping, 'user' => $user]);
            $entityManager->remove($like);
            $entityManager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimer ',
                'likes' => $campinglLikeRepository->count(['camping' => $camping])
            ], 200);
        }
        $like = new CampingLike();
        $like->setCamping($camping);
        $like->setUser($user);
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouter ',
            'likes' => $campinglLikeRepository->count(['camping' => $camping])
        ], 200);
    }
}
