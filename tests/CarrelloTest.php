<?php

namespace App\Tests;

use App\Repository\ProductRepository;
use App\Repository\ProductsInCartRepository;
use App\Repository\ShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class CarrelloTest extends WebTestCase
{
    protected $client;

    protected $manager;

    protected $connection;

    protected ProductRepository $productRepository;

    protected ShoppingCartRepository $shoppingCartRepository;

    protected ProductsInCartRepository $productInCartRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->manager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->productRepository = static::getContainer()->get(ProductRepository::class);
        $this->shoppingCartRepository = static::getContainer()->get(ShoppingCartRepository::class);
        $this->productInCartRepository = static::getContainer()->get(ProductsInCartRepository::class);

        $this->connection = $this->manager->getConnection();
        $this->connection->beginTransaction();
    }

    // protected function tearDown(): void
    // {
    //     $this->connection->rollback();
    //     parent::tearDown();
    // }
    
}
