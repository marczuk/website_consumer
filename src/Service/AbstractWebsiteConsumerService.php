<?php


namespace App\Service;


use App\Exception\ServiceUnavailableException;
use App\Parser\ParserInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractWebsiteConsumerService
{
    private $httpClient;

    protected $url;

    private $parser;

    /**
     * AbstractWebsiteConsumerService constructor.
     * @param string $url
     * @param HttpClientInterface $httpClient
     * @param ParserInterface $parser
     */
    public function __construct(string $url, HttpClientInterface $httpClient, ParserInterface $parser) {
        $this->url = $url;
        $this->httpClient = $httpClient;
        $this->parser = $parser;
    }

    public abstract function consume(): array;

    /**
     * Method to get content from URL address
     *
     * @return string
     * @throws ServiceUnavailableException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function getContent(): string {

        $response = $this->httpClient->request('GET', $this->url);

        // do this instead
        if (200 !== $response->getStatusCode()) {
            // handle the HTTP request error (e.g. retry the request)
            throw new ServiceUnavailableException('Site ' . $this->url . ' is temporary unavailable. Please try again later.');
        }

        return $response->getContent();
    }

    /**
     * Method to trigger injected parser of the website
     *
     * @param string $content
     * @return array - of objects that we want to receive from website
     */
    protected function getElements(string $content): array {
        return $this->parser->parse($content);
    }
}