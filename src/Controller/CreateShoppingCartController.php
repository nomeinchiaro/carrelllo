<?php

namespace App\Controller;

use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateShoppingCartController extends AbstractController
{
    #[Route(
        '/create/shopping/cart',
        name: 'create_shopping_cart',
        methods: ['POST']
    )]
    public function index(
        ShoppingCartRepository $repo
    ): Response {
        try {
            $cart = new ShoppingCart();
            $repo->createCart($cart);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 500);
        }

        return $this->json($cart, 201);
    }
}
