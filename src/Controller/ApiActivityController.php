<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Services\PaginatorService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiActivityController extends AbstractController
{
    private $paginatorService;
    private $managerRegistry;

    public function __construct(PaginatorService $paginatorService, ManagerRegistry $managerRegistry) {
        $this->paginatorService = $paginatorService;
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/api/activity', name: 'app_api_activity')]
    public function index(): Response
    {
        return $this->render('api_activity/index.html.twig', [
            'controller_name' => 'ApiActivityController',
        ]);
    }

    #[Route('/api/user/{userId}/activities', name: 'api_user_activities_by_date_range', methods: ['GET'])]
    public function getUserActivitiesByDateRange(Request $request, ActivityRepository $activityRepository, int $userId): JsonResponse
    {
        // Get the start and end date from the query parameters
        $startDate = new \DateTime($request->query->get('start_date', 'now'));
        $endDate = new \DateTime($request->query->get('end_date', 'now'));

        // Get the user's activities within the date range
        $userActivities = $activityRepository->filterUserActivitiesByDateRange($userId, $startDate, $endDate);
        $activitiesArray = [];
        foreach ($userActivities as $activity) {

             $activitiesArray[] = [
                 'id' => $activity->getId(),
                 'title' => $activity->getTitle(),
                 'descrption' =>$activity->getDescription(),
                 'date' => $activity->getDate()
             ];
        }

        return new JsonResponse($activitiesArray);
    }
}
