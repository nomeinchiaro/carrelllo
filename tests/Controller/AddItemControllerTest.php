<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Entity\ProductsInCart;
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
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'product created']),
            $this->client->getResponse()->getContent(),
        );
    }

    /** @test */
    public function zero(): void
    {
        $first = new Product;
        $first->setSku(42);
        $first->setName('First Product');
        $this->productRepository->createProduct($first);

        $cart = new ShoppingCart;
        $this->shoppingCartRepository->createCart($cart);

        $route = "/add/item/" . $cart->getUuid() . "/" . $first->getUuid() . '/0';
        $this->client->request('POST', $route);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'product not added']),
            $this->client->getResponse()->getContent(),
        );
    }

    /** @test */
    public function shouldUpdateQuantityOfAlreadyPresentProductInCart(): void
    {
        $first = new Product;
        $first->setSku(42);
        $first->setName('First Product');
        $this->productRepository->createProduct($first);

        $cart = new ShoppingCart();
        $this->shoppingCartRepository->createCart($cart);

        $productInCart = new ProductsInCart();
        $productInCart->setProduct($first);
        $productInCart->setCart($cart);
        $productInCart->setQuantity(3);
        $this->productInCartRepository->createItem($productInCart);

        $route = "/add/item/" . $cart->getUuid() . "/" . $first->getUuid() . '/2';
        $this->client->request('POST', $route);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'product updated']),
            $this->client->getResponse()->getContent(),
        );
    }

    /** @test */
    public function shouldDeleteProductFromCartWheneverQuantityIsZero(): void
    {
        $first = new Product;
        $first->setSku(42);
        $first->setName('First Product');
        $this->productRepository->createProduct($first);

        $cart = new ShoppingCart();
        $this->shoppingCartRepository->createCart($cart);

        $productInCart = new ProductsInCart();
        $productInCart->setProduct($first);
        $productInCart->setCart($cart);
        $productInCart->setQuantity(3);
        $this->productInCartRepository->createItem($productInCart);

        $route = "/add/item/" . $cart->getUuid() . "/" . $first->getUuid() . '/0';
        $this->client->request('POST', $route);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'product deleted']),
            $this->client->getResponse()->getContent(),
        );
    }
}
