<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testProfileShowLoads(): void
    {
        $client = static::createClient();
        $client->request('GET', '/profile');

        $this->assertResponseIsSuccessful();
    }

    public function testProfileEditLoads(): void
    {
        $client = static::createClient();
        $client->request('GET', '/profile/edit');

        $this->assertResponseIsSuccessful();
    }
}
