<?php

namespace GoDaddy\WordPress\OAuth\Client\Http;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\TypeHelper;
use GoDaddy\WordPress\OAuth\Client\Exceptions\HttpException;

/**
 * HTTP Client for OAuth API requests.
 *
 * Uses mwc-common Request/Response classes for making GET and POST
 * requests to the MWC OAuth API. Handles response parsing, error handling,
 * and exception throwing for various failure scenarios.
 */
class HttpClient
{
    /**
     * Make a GET request.
     *
     * Sends a GET request to the specified URL with optional query parameters.
     * Returns the parsed JSON response as an associative array.
     *
     * @param string $url The URL to request
     * @param array<string, mixed> $params Optional query parameters
     * @return array<string, mixed> Parsed JSON response
     * @throws HttpException If request fails
     */
    public function get(string $url, array $params = []) : array
    {
        $request = $this->createRequest($url)
            ->setMethod('GET')
            ->setQuery($params);

        return TypeHelper::arrayOfStringsAsKeys($this->send($request)->throw()->getBody());
    }

    /**
     * @throws HttpException
     */
    protected function createRequest(string $url) : Request
    {
        try {
            return new Request($url);
        } catch (Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception, $exception->getCode() ?: 500);
        }
    }

    /**
     * @throws HttpException
     */
    protected function send(Request $request) : Response
    {
        try {
            return $request->send();
        } catch (Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception, $exception->getCode() ?: 500);
        }
    }

    /**
     * Make a POST request.
     *
     * Sends a POST request to the specified URL with form-encoded data.
     * Returns the parsed JSON response as an associative array.
     *
     * @param string $url The URL to request
     * @param array<string, mixed> $data Optional form data
     * @return array<string, mixed> Parsed JSON response
     * @throws HttpException If request fails
     */
    public function post(string $url, array $data = []) : array
    {
        try {
            // catch the exception that setHeaders() says it throws even though it never throws when a valid array is given
            $request = $this->createRequest($url)
                ->setMethod('POST')
                ->setHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->setBody($data);
        } catch (Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception, $exception->getCode() ?: 500);
        }

        return TypeHelper::arrayOfStringsAsKeys($this->send($request)->throw()->getBody());
    }
}
