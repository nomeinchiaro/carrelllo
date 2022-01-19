<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class CarrelloTest extends WebTestCase
{
    protected $client;

    protected $manager;

    protected $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine.orm.entity_manager');

        $this->connection = $this->manager->getConnection();
        $this->connection->beginTransaction(); // this disable autocommit
    }
}
