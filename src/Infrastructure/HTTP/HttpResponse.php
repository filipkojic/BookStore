<?php

namespace Filip\Bookstore\Infrastructure\HTTP;

/**
 * Class HttpResponse
 *
 * Represents an HTTP response with methods to set the status code, headers, and body.
 */
class HttpResponse extends AbstractResponse
{
    /**
     * Send the HTTP response to the client.
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->body;
    }
}
