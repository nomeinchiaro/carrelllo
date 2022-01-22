<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\ShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddItemController extends AbstractController
{
    #[Route('/add/item/{cart}/{product}', name: 'add_item')]
    public function index(
        $cart,
        $product,
        ShoppingCartRepository $shoppingCartRepository,
        ProductRepository $productRepository,
    ): Response {

        $concreteCart = $shoppingCartRepository->findOneByUuid($cart);
        $concreteProduct = $productRepository->findOneByUuid($product);

        return $this->json([
            '$concreteCart' => $cart,
            '$concreteProduct' => $product,
        ], 201);
    }
}
