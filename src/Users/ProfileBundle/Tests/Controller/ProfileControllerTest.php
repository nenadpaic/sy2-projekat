<?php

namespace Users\ProfileBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/user-profile?id=1');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'ODgovor nije uspesan 404');
        $this->assertCount(2, $crawler->filter('img'), 'Ne postoje slike timeline i profile');
        $this->assertCount(1,$crawler->filter('html:contains("nenadpaic")'), 'Nije octitan parametar username');
        $this->assertCount(1,$crawler->filter('html:contains("Nenad")'), 'Nije octitan parametar firstname');
        $this->assertCount(1,$crawler->filter('html:contains("Paic")'), 'Nije octitan parametar lastname');
        $this->assertCount(1,$crawler->filter('html:contains("nenadpaic@gmail.com")'), 'Nije octitan parametar firstname');
        $this->assertCount(1,$crawler->filter('html:contains("Serbia")'), 'Nije octitan parametar country');
        $this->assertCount(1,$crawler->filter('html:contains("Vojvodina")'), 'Nije octitan parametar state');
        $this->assertCount(1,$crawler->filter('html:contains("Sombor")'), 'Nije octitan parametar city');
        $this->assertCount(1,$crawler->filter('html:contains("Stevana Beljanskog 13")'), 'Nije octitan parametar address');
        $this->assertCount(1,$crawler->filter('html:contains("0658126235")'), 'Nije octitan parametar phone');





    }

}
