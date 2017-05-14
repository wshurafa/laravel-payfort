<?php
use Goutte\Client;
use LaravelPayfort\Facades\Payfort;
use Symfony\Component\DomCrawler\Crawler;

class RedirectionRequestsTest extends TestCase
{
    /**
     * Testing displayRedirectionPage service
     *
     * @return void
     */
    public function testDisplayRedirectionPage()
    {
        $amount = '100';
        $currency = 'QAR';

        $view = Payfort::redirection()->displayRedirectionPage([
            'command' => 'AUTHORIZATION',
            'merchant_reference' => str_random(8),
            'amount' => $amount,
            'currency' => $currency,
            'customer_email' => 'example@example.com'
        ]);

        $html = $view->render();

        $crawler = new Crawler($html, 'https://sbcheckout.payfort.com/FortAPI/paymentPage');

        $form = $crawler->filter('form')->form();

        $client = new Client();

        $crawler = $client->submit($form);


        $this->assertNotEmpty($crawler->filter('label.value'));
        $this->assertContains($amount, $crawler->filter('label.value')->text());
        $this->assertContains($currency, $crawler->filter('label.value')->text());
    }

}