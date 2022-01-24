<?php

namespace App\Controller;

use App\Entity\Events;
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
        string $cart,
        string $product,
        int $quantity,
        ShoppingCartRepository $shoppingCartRepository,
        ProductRepository $productRepository,
        ProductsInCartRepository $productsInCartRepository,
        EntityManagerInterface $manager,
    ): Response {

        $concreteCart = $shoppingCartRepository->findOneByUuid($cart);
        $concreteProduct = $productRepository->findOneByUuid($product);

        $productInCart = $productsInCartRepository->findByCartAndProduct(
            $concreteCart,
            $concreteProduct
        );

        if ($quantity === 0 && $productInCart === null) {
            return $this->json([
                'message' => 'product not added'
            ], 200);
        }

        if ($productInCart === null) {

            $productInCart = new ProductsInCart;
            $productInCart->setCart($concreteCart);
            $productInCart->setProduct($concreteProduct);
            $productInCart->setQuantity($quantity);

            $manager->persist($productInCart);
            $manager->flush();

            // @todo move into a service, ... 
            $event = new Events();
            $event->setEventName('ProductAdded');
            $event->setDatetime(new \DateTime());
            $event->setMeta([
                'cart' => $concreteCart->getId(),
                'product' => $concreteProduct->getId(),
                'quantity' => $quantity,
            ]);
            $manager->persist($event);
            $manager->flush();

            return $this->json([
                'message' => 'product created'
            ], 201);
        }

        if ($quantity === 0) {
            $manager->remove($productInCart);
            $manager->flush();

            // @todo move into a service, ... 
            $event = new Events();
            $event->setEventName('ProductRemoved');
            $event->setDatetime(new \DateTime());
            $event->setMeta([
                'cart' => $concreteCart->getId(),
                'product' => $concreteProduct->getId(),
            ]);
            $manager->persist($event);
            $manager->flush();

            return $this->json([
                'message' => 'product deleted'
            ], 200);
        }

        $productInCart->setCart($concreteCart);
        $productInCart->setProduct($concreteProduct);
        $productInCart->setQuantity($quantity);

        $manager->persist($productInCart);
        $manager->flush();

        // @todo move into a service, ... 
        $event = new Events();
        $event->setEventName('ProductUpdated');
        $event->setDatetime(new \DateTime());
        $event->setMeta([
            'cart' => $concreteCart->getId(),
            'product' => $concreteProduct->getId(),
            'quantity' => $quantity,
        ]);
        $manager->persist($event);
        $manager->flush();

        return $this->json([
            'message' => 'product updated'
        ], 200);
    }
}
