<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CallBackControllerTest extends WebTestCase
{

    /**
     * @test
     */
    public function homepageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }


    /**
     * @test
     */
    public function listIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/fr_FR/list');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
     * register must redirect user to homepage
     * if there's no validate call request in session
     *
     * @test
     */
    public function registerRedirectToHomeWithoutValidateCR()
    {
        $client = static::createClient();
        $client->request('GET', '/fr_FR/register');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}