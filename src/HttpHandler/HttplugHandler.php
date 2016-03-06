<?php

namespace Google\Auth\HttpHandler;

use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpPlugHandler implements HttpHandler
{
  /**
   * @var HttpClient
   */
  private $client;

  /**
   * @param HttpClient $client
   */
  public function __construct(HttpClient $client)
  {
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public function __invoke(RequestInterface $request, array $options = [])
  {
    return $this->client->sendRequest($request);
  }
}
