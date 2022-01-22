<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Tests\CarrelloTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateShoppingCartControllerTest extends CarrelloTest
{
    /** @test */
    public function shouldCreateNewCartViaPostRequest(): void
    {
        $this->client->request('POST', '/create/shopping/cart');
        $this->assertResponseStatusCodeSame(201);
    }
}
