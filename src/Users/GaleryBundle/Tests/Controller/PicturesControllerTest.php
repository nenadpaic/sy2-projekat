<?php

namespace Users\GaleryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PicturesControllerTest extends WebTestCase
{
    public function testUpload()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/galery/upload/image');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/galery/image/delete');
    }

}
