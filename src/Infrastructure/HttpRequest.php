<?php

/**
 * Class HttpRequest
 *
 * Represents an HTTP request with methods to access query parameters, body parameters, headers, method, and URI.
 */
class HttpRequest
{
    /**
     * @var array Query parameters from the URL.
     */
    private array $queryParams;

    /**
     * @var array Body parameters from the POST request.
     */
    private array $bodyParams;

    /**
     * @var array Headers from the HTTP request.
     */
    private array $headers;

    /**
     * @var string HTTP method (e.g., GET, POST).
     */
    private string $method;

    /**
     * @var string URI of the HTTP request.
     */
    private string $uri;

    /**
     * HttpRequest constructor.
     * Initializes the request parameters from the global PHP variables.
     */
    public function __construct()
    {
        $this->queryParams = $_GET;
        $this->bodyParams = $_POST;
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    /**
     * Get a query parameter from the URL.
     *
     * @param string $key The key of the query parameter.
     * @param string|null $default The default value to return if the key is not found.
     * @return string|null The value of the query parameter or the default value.
     */
    public function getQueryParam(string $key, ?string $default = null): ?string
    {
        return $this->queryParams[$key] ?? $default;
    }

    /**
     * Get a body parameter from the POST request.
     *
     * @param string $key The key of the body parameter.
     * @param string|null $default The default value to return if the key is not found.
     * @return string|null The value of the body parameter or the default value.
     */
    public function getBodyParam(string $key, ?string $default = null): ?string
    {
        return $this->bodyParams[$key] ?? $default;
    }

    /**
     * Get a header from the HTTP request.
     *
     * @param string $key The key of the header.
     * @param string|null $default The default value to return if the key is not found.
     * @return string|null The value of the header or the default value.
     */
    public function getHeader(string $key, ?string $default = null): ?string
    {
        return $this->headers[$key] ?? $default;
    }

    /**
     * Get the HTTP method of the request.
     *
     * @return string The HTTP method (e.g., GET, POST).
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get the URI of the HTTP request.
     *
     * @return string The URI of the request.
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
