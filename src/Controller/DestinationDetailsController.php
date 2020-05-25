<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DestinationDetailsController extends AbstractController
{
    /**
     * @Route("/destination/details", name="destination_details")
     */
    public function index()
    {
        return $this->render('destination_details/index.html.twig', [
            'controller_name' => 'DestinationDetailsController',
        ]);
    }
}
