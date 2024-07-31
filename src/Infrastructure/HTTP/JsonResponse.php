<?php

namespace Filip\Bookstore\Infrastructure\HTTP;

/**
 * Class JsonResponse
 *
 * Represents a JSON response with methods to set the status code, headers, and body.
 */
class JsonResponse extends AbstractResponse
{
    /**
     * Send the JSON response to the client.
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        $this->addHeader('Content-Type', 'application/json');

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->body;
    }
}
