<?php

namespace App\Tests;

use App\Entity\ShoppingCart;
use Symfony\Component\Uid\Uuid;

class ShoppingCartTest extends CarrelloTest
{
    /** @test */
    public function shouldReturn201WheneverPostCallIsValid(): void
    {
        $this->client->jsonRequest('POST', '/api/shopping_carts', [ 'uuid' => (string) Uuid::v4(), ]);
        $this->assertResponseStatusCodeSame(201);
    }

    /** @test */
    public function shouldReturnEmptyArrayWheneverNoItemsAreInTheCart(): void
    {
        $this->client->jsonRequest('GET', '/api/shopping_carts');
        $this->assertEquals([], json_decode($this->client->getResponse()->getContent(), true));
    }

    /** @test */
    public function shouldListAllItemsInShoppingCart(): void
    {
        $uuid = Uuid::v4();
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setUuid($uuid);
        $this->manager->persist($shoppingCart);
        $this->manager->flush();

        $this->client->jsonRequest('GET', '/api/shopping_carts');

        $json = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue(isset($json[0]['uuid']));
    }
}
