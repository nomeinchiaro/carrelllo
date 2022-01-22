<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FakeController extends AbstractController
{
    #[Route('/fake', name: 'fake')]
    public function index(): Response
    {
        return $this->render('fake/index.html.twig', [
            'controller_name' => 'FakeController',
        ]);
    }
}
