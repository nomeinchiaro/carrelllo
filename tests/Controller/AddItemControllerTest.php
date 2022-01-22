<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Tests\CarrelloTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddItemControllerTest extends CarrelloTest
{
    /** @test */
    public function shouldAddProducts(): void
    {
        $product = new Product;
        $product->setSku(42);
        $product->setName('Product Name');
        $this->productRepository->createProduct($product);

        $cart = new ShoppingCart;
        $this->shoppingCartRepository->createCart($cart);

        $route = "/add/item/" . $cart->getUuid() . "/" . $product->getUuid();

        $this->client->request('POST', $route);
        $this->assertResponseStatusCodeSame(201);
    }
}
