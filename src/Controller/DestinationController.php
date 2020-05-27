<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VilleRepository;


class DestinationController extends AbstractController
{
    /**
     * @Route("/destination", name="destination")
     */
    public function index(VilleRepository $villeRepository)
    {
        $villes = $villeRepository->findAll();
        // $region = $regionRepository->findOneBy(array('id' => ));
        return $this->render('destination/index.html.twig', [
            'controller_name' => 'DestinationController', 'villes' => $villes,
        ]);
    }
}
