<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\HotelLike;
use App\Form\Hotel2Type;
use App\Repository\HotelLikeRepository;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hotel")
 */
class HotelController extends AbstractController
{
    /**
     * @Route("/", name="hotel_index", methods={"GET"})
     */
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hotel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(Hotel2Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('hotel_index');
        }

        return $this->render('hotel/new.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hotel_show", methods={"GET"})
     */
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hotel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hotel $hotel): Response
    {
        $form = $this->createForm(Hotel2Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hotel_index');
        }

        return $this->render('hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hotel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hotel $hotel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hotel_index');
    }

     /**
     * @Route("/{id}/like", name="hotel_like")
     */
    public function like(Hotel $hotel, HotelLikeRepository $hotelLikeRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['code' => 403, 'message' => 'Unthauthorized'], 403);
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($hotel->isLikedByUser($user)) {

            $like = $hotelLikeRepository->findOneBy(['hotel' => $hotel, 'user' => $user]);
            $entityManager->remove($like);
            $entityManager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimer ',
                'likes' => $hotelLikeRepository->count(['hotel' => $hotel])
            ], 200);
        }
        $like = new HotelLike();
        $like->setHotel($hotel);
        $like->setUser($user);
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouter ',
            'likes' => $hotelLikeRepository->count(['hotel' => $hotel])
        ], 200);
    }
}
