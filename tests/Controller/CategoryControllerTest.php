<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/category');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSelectorTextContains('html h1', 'Categorías');
    }

    public function testCreate()
    {
        $client = static::createClient();
        $client->request('GET', '/category');

        $crawler = $client->clickLink('Crear Categoría');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Nueva Categoría');
    }

    public function testDetail()
    {
        $client = static::createClient();
        $client->request('GET', '/category');
        
        $crawler = $client->clickLink('Detalles');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Detalle de la categoría');
    }
    
    public function testEdit()
    {
        $client = static::createClient();
        $client->request('GET', '/category');

        $crawler = $client->clickLink('Editar');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Editar Categoría');
    }

}