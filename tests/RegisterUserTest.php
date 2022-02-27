<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{

    public function setUp(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
    }
    
    public function testRegisterPageIsDisplayed(): void
    {
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Register');
    }

    public function testFormContainsAllFields(): void
    {
        $this->assertSelectorTextContains('label', 'Email');
        $this->assertSelectorTextContains('label', 'Username');
        $this->assertSelectorTextContains('label', 'Password');
    }
}
