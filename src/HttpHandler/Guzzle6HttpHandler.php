<?php

namespace Google\Auth\HttpHandler;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Guzzle6HttpHandler implements HttpHandler
{
  /**
   * @var ClientInterface
   */
  private $client;

  /**
   * @param ClientInterface $client
   */
  public function __construct(ClientInterface $client)
  {
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public function __invoke(RequestInterface $request, array $options = [])
  {
    return $this->client->send($request, $options);
  }
}
