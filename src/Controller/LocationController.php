<?php

namespace App\Controller;

use DateTimeInterface;
use App\Entity\Location;
use App\Form\AddLocationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocationController extends AbstractController
{
    /**
     * @Route("/location", name="app_location")
     */
    public function index(): Response
    {
        return $this->render('location/index.html.twig', [
            'controller_name' => 'LocationController',
        ]);
    }



    /**
     * @Route("/locations", name="locations-list")
     */
    public function locationsList(Request $request, SerializerInterface $serializer)
    {
        $locationRepo = $this->getDoctrine()->getRepository(Location::class);
        $locations = $locationRepo->findAll();







        return $this->render('location/locations.html.twig', [
            'controller_name' => 'LocationController',
            'locations' => $locations
        ]);
    }

    /**
     * @Route("/location-ajout", name="create_location")]
     */
    public function createLocation(Request $request): Response
    {

        $location = new Location();

        $locationForm = $this->createForm(AddLocationType::class, $location);
        $locationForm->handleRequest($request);

        if ($locationForm->isSubmitted() && $locationForm->isValid()) {
            $this->getDoctrine()->getManager()->persist($location);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('locations-list');
        }
        return $this->render('location/location-ajout.html.twig', [
            'locationForm' => $locationForm->createView()
        ]);
    }

    /**
     * @Route("/location-suppression/{id}", name="delete_location")]
     */
    public function deleteLocation(SerializerInterface $serializer, Request $request, $id)
    {

        $locationRepository = $this->getDoctrine()->getRepository(Location::class);
        $locationToDelete = $locationRepository->findOneBy(['id' => $id]);

        $this->getDoctrine()->getManager()->remove($locationToDelete);
        $this->getDoctrine()->getManager()->flush();

        $locations = "locations";
        /*$location = $serializer->serialize($locationToDelete, 'json', ["locations" => $locations]);
         return new JsonResponse($location, Response::HTTP_OK, [], true); */
        return $this->redirectToRoute('locations-list');
    }
}
