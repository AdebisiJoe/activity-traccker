<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

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


    #[Route('/users', name: 'users')]
    public function appUsers(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->remove('theme');

        return $this->redirectToRoute('home');
    }


}
