<?php

namespace App\Tests\Parser;

use App\Model\VidexProductModel;
use App\Parser\VidexParser;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class VidexParserTest extends TestCase
{
    private $productTitle = 'Option 480 Mins';
    private $productPrice = 9494;
    private $productDiscount = 'Save £5 on the monthly price';

    private $videxProductSite;

    private $parser;

    protected function setUp(): void
    {
        $this->parser = new VidexParser(new Crawler());
        $this->videxProductSite = '
    <div class="widget block block-static-block">
<section id="subscriptions" class="content_section grid">
<div class="row" style="margin-left:0px; margin-right:0px>
        <div class="top-line-decoration"></div>
        <h2>Annual Subscription Packages</h2>
        <div class="colored-line"></div>
        <div class="sub-heading">
            Choose from the packages below and get your product connected, each with per second billing.
        </div>
        <div class="pricing-table">
            <div class="row-subscriptions" style="margin-bottom:40px;">
                <div class="col-xs-4">
                    <div class="package featured-right" style="margin-top:0px; margin-right:0px; margin-bottom:0px; margin-left:25px">
                        <div class="header dark-bg">
                            <h3>' . $this->productTitle . '</h3>
                        </div>
                        <div class="package-features">
                            <ul>
                                <li>
                                    <div class="package-name">Up to 480 minutes talk time per year<br />including 240 SMS<br/>(5p / minute and 4p / SMS thereafter)</div>
                                </li>
                                <li>
                                    <div class="package-price"><span class="price-big">£'.$this->productPrice.'.00</span><br />(inc. VAT)<br />Per Year
                                        <p style="color: red">'. $this->productDiscount . '</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="package-data">12 Months - Voice & SMS Service Only</div>
                                </li>
                            </ul>
                            <div class="bottom-row">
                                <a class="btn btn-primary main-action-button" href="activate" role="button">Choose</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- /END PACKAGE -->
            </div>
        </div>
    </div>
</section>
</div>
    ';
    }

    public function testParse()
    {
        //action
        /** @var VidexProductModel[] $products */
        $products = $this->parser->parse($this->videxProductSite);

        //assert
        $this->assertEquals($this->productTitle, $products[0]->getTitle());
        $this->assertEquals($this->productPrice, $products[0]->getPrice());
        $this->assertEquals($this->productDiscount, $products[0]->getDiscount());
    }
}
