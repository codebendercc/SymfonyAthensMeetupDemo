<?php

namespace Codebender\DefaultBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{

    public function testAddBook() {
        // Create a new client to browse the application
        $client = static::createClient();

        // Navigate to the book addition page
        $crawler = $client->request('GET', '/book/new');
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'codebender_defaultbundle_book[isbn]'  => '1234',
            'codebender_defaultbundle_book[title]'  => 'Book title',
            'codebender_defaultbundle_book[author]'  => 'An author',
            'codebender_defaultbundle_book[year]'  => '2015',
            'codebender_defaultbundle_book[shelf]'  => '1',
            'codebender_defaultbundle_book[section]'  => '2',
            'codebender_defaultbundle_book[available]'  => true
        ));

        $client->submit($form);
        
        // Navigate to the book addition page
        $crawler = $client->request('GET', '/book/');
        
        $this->assertEquals(1, $crawler->filter('td:Contains("Book title")')->count());
    }
}
