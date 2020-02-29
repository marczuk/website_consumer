<?php

namespace App\Tests\Model;

use App\Model\VidexProductModel;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class VidexProductModelTest extends TestCase
{

    /** @var int */
    private $minPrice = null;

    /** @var int */
    private $maxPrice = null;

    /** @var VidexProductModel[] */
    private $objects = [];

    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();

        //create ten fake products
        for ($i = 0; $i < 10; $i++) {
            $this->createProductModel();
        }
    }

    public function testJsonSerialize()
    {
        //check first product is serializable
        $product = $this->objects[0];

        $json = json_encode($product);

        $this->assertStringContainsString($product->getTitle(), $json);
        $this->assertStringContainsString($product->getDescription(), $json);
        $this->assertStringContainsString($product->getPrice(), $json);
        $this->assertStringContainsString($product->getDiscount(), $json);
    }

    public function testCompareByPrice()
    {
        usort($this->objects, array(VidexProductModel::class, 'compareByPrice'));

        //check first element - should be max
        $this->assertEquals($this->maxPrice, $this->objects[0]->getPrice());

        //check last element - should be min
        $this->assertEquals($this->minPrice, $this->objects[sizeof($this->objects)-1]->getPrice());
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

        $this->objects[] =$product;
    }
}
