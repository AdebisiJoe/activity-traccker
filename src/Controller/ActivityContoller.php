<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Services\PaginatorService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ActivityContoller extends AbstractController
{
    private $paginatorService;
    private $managerRegistry;

    public function __construct(PaginatorService $paginatorService, ManagerRegistry $managerRegistry) {
        $this->paginatorService = $paginatorService;
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(Request $request, ActivityRepository $activityRepository): Response
    {

        if(!$this->getUser()) {
            return $this->redirect("/login");
        }

        return $this->render('activity/index.html.twig', [
            'activities' =>  $this->paginatorService->paginate($activityRepository->findAll(), $request),
        ]);
    }
}
