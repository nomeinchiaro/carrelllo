<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Tests\CarrelloTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddItemControllerTest extends CarrelloTest
{
    /** @test */
    public function shouldAddProductIntoTheCart(): void
    {
        $first = new Product;
        $first->setSku(42);
        $first->setName('First Product');
        $this->productRepository->createProduct($first);

        $cart = new ShoppingCart;
        $this->shoppingCartRepository->createCart($cart);

        $route = "/add/item/" . $cart->getUuid() . "/" . $first->getUuid() . '/2';
        $this->client->request('POST', $route);
        $this->assertResponseStatusCodeSame(201);
    }

    /** @test */
    public function shouldAddProductsIntoTheCart(): void
    {
        $first = new Product;
        $first->setSku(42);
        $first->setName('First Product');
        $this->productRepository->createProduct($first);

        $second = new Product;
        $second->setSku(43);
        $second->setName('First Product');
        $this->productRepository->createProduct($second);

        $cart = new ShoppingCart;
        $this->shoppingCartRepository->createCart($cart);

        $route = "/add/item/" . $cart->getUuid() . "/" . $first->getUuid() . '/2';
        $this->client->request('POST', $route);
        $this->assertResponseStatusCodeSame(201);

        $route = "/add/item/" . $cart->getUuid() . "/" . $second->getUuid() . '/2';
        $this->client->request('POST', $route);
    }
}
