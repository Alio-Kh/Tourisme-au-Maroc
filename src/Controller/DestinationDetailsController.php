<?php

namespace App\Controller;

use App\Repository\MarkerRepository;
use App\Repository\HotelRepository;
use App\Repository\RestoRepository;
use App\Repository\ActiviteRepository;
use App\Repository\CampingRepository;
use App\Repository\VilleRepository;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DestinationDetailsController extends AbstractController
{
    /**
     * @Route("/{name}/details", name="destination_details" , methods={"GET","POST"})
     */
    public function index(Request $request, $name, MarkerRepository $markerRepository, HotelRepository $hotelRepository, RestoRepository $restoRepository, 
    ActiviteRepository $activiteRepository, CampingRepository $campingRepository, VilleRepository $villeRepository)
    {
        $ville = $villeRepository->findOneBy(array('name' => $name));
        $hotelMarkers = $markerRepository->findBy(array('type' => 'hotel', 'ville' => $ville));
        $restoMarkers = $markerRepository->findBy(array('type' => 'resto', 'ville' => $ville));
        $activiteMarkers = $markerRepository->findBy(array('type' => 'activite', 'ville' => $ville));
        $campingMarkers = $markerRepository->findBy(array('type' => 'camping', 'ville' => $ville));
        $hotels = $hotelRepository->findBy(array('ville' => $ville));
        $restos = $restoRepository->findBy(array('ville' => $ville));
        $activites = $activiteRepository->findBy(array('ville' => $ville));
        $campings = $campingRepository->findBy(array('ville' => $ville));
        $villeMarker = $markerRepository->findOneBy(array('type' => 'ville', 'ville' => $ville));
        return $this->render('destination_details/index.html.twig', [
            'controller_name' => 'DestinationDetailsController', 'villeMarker' => $villeMarker, 'ville' => $ville,
             'hotelMarkers' => $hotelMarkers, 'hotels' => $hotels, 'restos' => $restos, 'activites' => $activites, 'campings' => $campings,
             'restoMarkers' => $restoMarkers, 'activiteMarkers' => $activiteMarkers, 'campingMarkers' => $campingMarkers,
        ]);
    }
}
