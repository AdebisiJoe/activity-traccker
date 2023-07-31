<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\UserRepository;
use App\Services\PaginatorService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $paginatorService;
    private $managerRegistry;

    public function __construct(PaginatorService $paginatorService, ManagerRegistry $managerRegistry) {
        $this->paginatorService = $paginatorService;
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    #[Route('/dark-mode', name: 'dark-mode')]
    public function themeDark(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->set('theme', 'dark');

        return $this->redirectToRoute('home');
    }

    #[Route('/light-mode', name: 'light-mode')]
    public function themeLight(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->remove('theme');

        return $this->redirectToRoute('home');
    }


    #[Route('/', name: 'home')]
    public function appUsers(Request $request, UserRepository $userRepository): Response
    {
        if(!$this->getUser()) {
            return $this->redirect("/login");
        }

        return $this->render('user/index.html.twig', [
            'users' =>  $this->paginatorService->paginate($userRepository->findAll(), $request),
        ]);
    }


}
