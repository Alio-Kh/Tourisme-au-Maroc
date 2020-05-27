<?php

namespace App\Controller;

use App\Repository\MarkerRepository;
use App\Repository\HotelRepository;
use App\Repository\RestoRepository;
use App\Repository\ActiviteRepository;
use App\Repository\CampingRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DestinationDetailsController extends AbstractController
{
    /**
     * @Route("/destination/details", name="destination_details")
     */
    public function index(MarkerRepository $markerRepository, HotelRepository $hotelRepository, RestoRepository $restoRepository, 
    ActiviteRepository $activiteRepository, CampingRepository $campingRepository, VilleRepository $villeRepository)
    {
        $markers = $markerRepository->findAll();
        $ville = $villeRepository->findBy(array('name' => "Ouarzazate"));
        $hotelMarkers = $markerRepository->findBy(array('type' => 'hotel', 'ville' => $ville));
        $restoMarkers = $markerRepository->findBy(array('type' => 'resto', 'ville' => $ville));
        $activiteMarkers = $markerRepository->findBy(array('type' => 'activite', 'ville' => $ville));
        $campingMarkers = $markerRepository->findBy(array('type' => 'camping', 'ville' => $ville));
        $hotels = $hotelRepository->findBy(array('ville' => $ville));
        $restos = $restoRepository->findBy(array('ville' => $ville));
        $activites = $activiteRepository->findBy(array('ville' => $ville));
        $campings = $campingRepository->findBy(array('ville' => $ville));
        return $this->render('destination_details/index.html.twig', [
            'controller_name' => 'DestinationDetailsController', 'markers' => $markers,
             'hotelMarkers' => $hotelMarkers, 'hotels' => $hotels, 'restos' => $restos, 'activites' => $activites, 'campings' => $campings,
             'restoMarkers' => $restoMarkers, 'activiteMarkers' => $activiteMarkers, 'campingMarkers' => $campingMarkers,
        ]);
    }
}
