<?php

namespace App\Controller;

use App\Entity\Marker;
use App\Form\Marker1Type;
use App\Repository\MarkerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marker")
 */
class MarkerController extends AbstractController
{
    /**
     * @Route("/", name="marker_index", methods={"GET"})
     */
    public function index(MarkerRepository $markerRepository): Response
    {
        return $this->render('marker/index.html.twig', [
            'markers' => $markerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="marker_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $marker = new Marker();
        $form = $this->createForm(Marker1Type::class, $marker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marker);
            $entityManager->flush();

            return $this->redirectToRoute('marker_index');
        }

        return $this->render('marker/new.html.twig', [
            'marker' => $marker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marker_show", methods={"GET"})
     */
    public function show(Marker $marker): Response
    {
        return $this->render('marker/show.html.twig', [
            'marker' => $marker,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="marker_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Marker $marker): Response
    {
        $form = $this->createForm(Marker1Type::class, $marker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marker_index');
        }

        return $this->render('marker/edit.html.twig', [
            'marker' => $marker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marker_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Marker $marker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marker->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('marker_index');
    }
}
