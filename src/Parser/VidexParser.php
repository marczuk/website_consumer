<?php


namespace App\Parser;


use App\Model\VidexProductModel;
use Symfony\Component\DomCrawler\Crawler;

class VidexParser implements ParserInterface
{

    private $crawler;

    /**
     * VidexParser constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Getting products from html content
     *
     * @param string $content
     * @return array - products array
     */
    public function parse(string $content): array
    {
        $this->crawler->addContent($content);

        //search for videx specific elements
        $elements = $this->crawler->filter('body')->filter('div.package')
            ->each(function (Crawler $node, $i) {
            $videxProduct = new VidexProductModel();

            $videxProduct
                ->setTitle($this->parseTitle($node))
                ->setDescription($this->parseDescription($node))
                ->setPrice($this->parsePrice($node))
                ->setDiscount($this->parseDiscount($node))
            ;
            return $videxProduct;
        });

        return $elements;

    }

    private function parseTitle(Crawler $node) : string {
        return $this->filterElement($node, 'h3');
    }

    private function parseDescription(Crawler $node) : string {
        return $this->filterElement($node, 'div.package-name');
    }

    private function parsePrice(Crawler $node) : int {
        $priceText = $this->filterElement($node, 'div.package-price span.price-big');

        return intval(mb_substr($priceText, 1));
    }

    private function parseDiscount(Crawler $node) : string {
        return $this->filterElement($node, 'div.package-price p');
    }

    private function filterElement($node, string $path) : string {
        return $node->filter($path)->count() ?
            $node->filter($path)->text() : '';
    }
}