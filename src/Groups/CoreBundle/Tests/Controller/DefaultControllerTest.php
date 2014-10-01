<?php

namespace Groups\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/groups');

       // $this->assertTrue($crawler->filter('html:contains("lk")')->count() > 0);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Nije uspesan url zahtev');

        $this->assertCount(2,$crawler->filter('h2'), 'Mora biti 3 naslova');
    }
}
