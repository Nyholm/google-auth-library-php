<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Auth\HttpHandler;

use Google\Auth\HttpHandler\Guzzle5HttpHandler;
use Google\Auth\HttpHandler\Guzzle6HttpHandler;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

class HttpHandlerFactory
{
  /**
   * Builds out a http handler. First check if any Httplug clients is installed and fallback on an installed version
   * of Guzzle.
   *
   * @return HttpHandler
   * @throws \Exception
   */
  public static function build($client = null)
  {
    if ($client instanceof HttpClient) {
      return new HttpPlugHandler($client);
    }

    if ($client === null) {
      // Try to find a client with auto discovery
      try {
        $client = HttpClientDiscovery::find();

        return new HttpPlugHandler($client);
      } catch (\Exception $e) {
        // if auto discovery fails, use Guzzle
        $client = new Client();
      }
    }

    $version = ClientInterface::VERSION;
    switch ($version[0]) {
      case '5':
          return new Guzzle5HttpHandler($client);
      case '6':
          return new Guzzle6HttpHandler($client);
      default:
          throw new \Exception(sprintf('Version %s of Guzzle is not supported.', $version));
    }
  }
}
