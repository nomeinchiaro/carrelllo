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
        $cart = new ShoppingCart();
        $repo->createCart($cart);

        return $this->json($cart, 201);
    }
}
