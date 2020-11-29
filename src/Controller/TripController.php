<?php

namespace App\Controller;

use App\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\TripRepository;

class TripController extends AbstractController
{
    private $tripRepository;

    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
    * @Route("/trip/{id}", name="get_one_category", methods={"GET"})
    */
    public function getTripById($id): JsonResponse
    {
        $trip = $this->tripRepository->findOneBy(['id' => $id]);

        if (empty($trip) || empty($id)) {
            throw new NotFoundHttpException('Not found!');
        }

        $data = [
            'id' => $trip->getId(),
            'name' => $trip->getName(),
            'destenation' => $trip->getDestenation(),
            'fellowPassenger' => $trip->getFellowPassenger(),
            'tripStartDate' => $trip->getTripStartDate(),
            'tripEndDate' => $trip->getTripEndDate(),
            'isPackingFinished' => $trip->getIsPackingFinished(),
        ];
    
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/trip/add", name="add_trip", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $destination = $data['destination'];
        $fellowPassenger = $data['fellowPassenger'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];

        if (empty($name) || empty($destination) || empty($fellowPassenger) || empty($startDate) || empty($endDate)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $resData = $this->tripRepository->saveTrip($name, $destination, $fellowPassenger, $startDate, $endDate);

        return new JsonResponse(['status' => 'Trip created!', 'data' => $resData], Response::HTTP_CREATED);
    }

    /**
     * @Route("/trips", name="get_all_trips", methods={"GET"})
     */
    public function getAll(Request $request): JsonResponse
    {
    }

    /**
     * @Route("/trip/done", name="mark_trip_as_done", methods={"POST"})
     */
    public function markTripAsDone(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $trip_id = $data['id'];

        if (empty($trip_id)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->tripRepository->updateTrip($trip_id, '', '', '', true);

        return new JsonResponse(['status' => 'Trip created!'], Response::HTTP_OK);
    }
}
