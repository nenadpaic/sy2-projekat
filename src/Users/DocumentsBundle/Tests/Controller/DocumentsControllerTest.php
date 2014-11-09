<?php

namespace Users\DocumentsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentsControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/documents');
    }

    public function testUpload()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/documents/new');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/documents/delete');
    }

}
