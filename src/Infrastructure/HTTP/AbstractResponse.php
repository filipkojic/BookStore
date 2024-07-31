<?php

namespace Filip\Bookstore\Infrastructure\HTTP;

/**
 * Class AbstractResponse
 *
 * Represents an abstract HTTP response with methods to set the status code, headers, and body.
 */
abstract class AbstractResponse
{
    /**
     * AbstractResponse constructor.
     * Initializes the response with a default status code and empty headers and body.
     *
     * @param int $statusCode HTTP status code (e.g., 200, 404).
     * @param array $headers Headers to be sent with the response.
     * @param string $body Body of the response.
     */
    public function __construct(
        protected int $statusCode = 200,
        protected array $headers = [],
        protected string $body = ''
    ) {}

    /**
     * Set the HTTP status code for the response.
     *
     * @param int $statusCode The HTTP status code.
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Get the HTTP status code of the response.
     *
     * @return int The HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Add a header to the response.
     *
     * @param string $key The header name.
     * @param string $value The header value.
     */
    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Get the headers of the response.
     *
     * @return array An associative array of headers.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the body of the response.
     *
     * @param string $body The body content.
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Get the body of the response.
     *
     * @return string The body content.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Send the HTTP response to the client.
     */
    abstract public function send(): void;
}
