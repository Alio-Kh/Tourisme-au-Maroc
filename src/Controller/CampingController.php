<?php

namespace App\Controller;

use App\Entity\Camping;
use App\Form\Camping1Type;
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
        $form = $this->createForm(Camping1Type::class, $camping);
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
        $form = $this->createForm(Camping1Type::class, $camping);
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
}
