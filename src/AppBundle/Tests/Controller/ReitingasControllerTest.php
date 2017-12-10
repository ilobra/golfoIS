<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReitingasControllerTest extends WebTestCase
{
    public function testRanking()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ranking');
    }

}
