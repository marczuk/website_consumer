<?php


namespace App\Service;


use App\Model\VidexProductModel;

class VidexWebsiteConsumerService extends AbstractWebsiteConsumerService
{

    /**
     * Main method to get elements from the website in the right order
     *
     * @return array
     * @throws \App\Exception\ServiceUnavailableException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function consume(): array
    {

        $content = $this->getContent();

        //get our products from the site content
        $elements = $this->getElements($content);

        //sort elements by price Descending
        usort($elements, array(VidexProductModel::class, 'compareByPrice'));

        return $elements;
    }
}