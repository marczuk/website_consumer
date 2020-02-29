<?php

namespace App\Tests\Service;

use App\Model\VidexProductModel;
use App\Parser\ParserInterface;
use App\Service\VidexWebsiteConsumerService;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class VidexWebsiteConsumerServiceTest extends TestCase
{

    /** @var int */
    private $minPrice = null;

    /** @var int */
    private $maxPrice = null;

    private $consumerService;

    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();

        $callback = function ($method, $url, $options) {
            return new MockResponse('<body><div class="test">testing</div></body>');
        };

        $client = new MockHttpClient($callback);

        // Create a stub for the SomeClass class.
        $parserStub = $this->createMock(ParserInterface::class);

        // Configure the stub.
        $parserStub->method('parse')
            ->willReturn([$this->createProductModel(), $this->createProductModel()]);

        $this->consumerService = new VidexWebsiteConsumerService('http://test_urlsdf123123.php', $client, $parserStub);

    }


    public function testConsume()
    {
        /** @var VidexProductModel[] $results */
        $results = $this->consumerService->consume();

        //check first element - should be max
        $this->assertEquals($this->maxPrice, $results[0]->getPrice());

        //check last element - should be min
        $this->assertEquals($this->minPrice, $results[sizeof($results)-1]->getPrice());

    }

    private function createProductModel(){
        $product = new VidexProductModel();
        $price = $this->faker->randomDigitNotNull();

        if (is_null($this->maxPrice) || $this->maxPrice < $price) {
            $this->maxPrice = $price;
        }

        if (is_null($this->minPrice) || $this->minPrice > $price) {
            $this->minPrice = $price;
        }

        $product->setTitle($this->faker->sentence(3))
            ->setDescription($this->faker->text())
            ->setPrice($price)
            ->setDiscount($this->faker->sentence(6))
        ;

        return $product;
    }
}
