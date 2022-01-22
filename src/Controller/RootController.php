<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RootController extends AbstractController
{
    #[Route('/', name: 'root')]
    public function index(): Response
    {
        $it = 'works';
        $how = 'well';
        $pwd = __FILE__;

        return $this->json(compact('it', 'how', 'pwd'));
    }

    #[Route('/root', name: 'root_root')]
    public function root(): Response
    {
        return $this->json([
            'ciao' => 'mondo',
        ]);
    }
}
