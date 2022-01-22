<?php

namespace App\Controller;

use App\Entity\ProductsInCart;
use App\Repository\ProductRepository;
use App\Repository\ProductsInCartRepository;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddItemController extends AbstractController
{
    #[Route('/add/item/{cart}/{product}/{quantity}', name: 'add_item')]
    public function index(
        $cart,
        $product,
        $quantity,
        ShoppingCartRepository $shoppingCartRepository,
        ProductRepository $productRepository,
        ProductsInCartRepository $productsInCartRepository,
        EntityManagerInterface $manager,
    ): Response {

        $concreteCart = $shoppingCartRepository->findOneByUuid($cart);
        $concreteProduct = $productRepository->findOneByUuid($product);

        $productInCart = $productsInCartRepository->findOneBy([
            'cart' => $concreteCart,
            'product' => $concreteProduct,
        ]);

        if ($productInCart === null) {
            $productInCart = new ProductsInCart;
            $productInCart->setProduct($concreteProduct);
            $productInCart->setCart($concreteCart);
        }

        $productInCart->setQuantity($quantity);
        $manager->persist($productInCart);
        $manager->flush();

        return $this->json([
            '$concreteCart' => $cart,
            '$concreteProduct' => $product,
            '$quantity' => $quantity,
        ], 201);
    }
}
