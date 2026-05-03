<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnimalControllerTest extends WebTestCase
{
    public function testAnimalIndexLoads(): void
    {
        $client = static::createClient();
        $client->request('GET', '/animals');

        $this->assertResponseIsSuccessful();
    }

    public function testAnimalDetailNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/animals/99999');

        $this->assertResponseStatusCodeSame(404);
    }
}
