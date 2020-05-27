<?php

namespace App\Controller;

use App\Repository\MarkerRepository;
use App\Repository\HotelRepository;
use App\Repository\RestoRepository;
use App\Repository\ActiviteRepository;
use App\Repository\CampingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DestinationDetailsController extends AbstractController
{
    /**
     * @Route("/destination/details", name="destination_details")
     */
    public function index(MarkerRepository $markerRepository, HotelRepository $hotelRepository, RestoRepository $restoRepository, ActiviteRepository $activiteRepository, CampingRepository $campingRepository)
    {
        $markers = $markerRepository->findAll();
        $hotels = $hotelRepository->findAll();
        $restos = $restoRepository->findAll();
        $activites = $activiteRepository->findAll();
        $campings = $campingRepository->findAll();
        return $this->render('destination_details/index.html.twig', [
            'controller_name' => 'DestinationDetailsController', 'markers' => $markers,
             'hotels' => $hotels, 'restos' => $restos, 'activites' => $activites,
             'campings' => $campings, 
        ]);
    }
}
