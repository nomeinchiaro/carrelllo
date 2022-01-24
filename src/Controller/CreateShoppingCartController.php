<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Events\Event;
use DateTime;

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

        // @todo move into a service, ... 
        $event = new Events();
        $event->setEventName('CartCreated');
        $event->setDatetime(new DateTime());
        $event->setMeta([
            'cart' => [
                'id' => $cart->getId(),
                'uuid' => $cart->getUuid(),
            ],
        ]);
        $manager->persist($event);
        $manager->flush();

        return $this->json($cart, 201);
    }
}
