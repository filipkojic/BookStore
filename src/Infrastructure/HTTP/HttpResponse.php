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
     * Set the body of the response using a view file.
     *
     * @param string $viewFile The path to the view file.
     * @param array $data Data to be extracted and passed to the view.
     */
    public function setBodyFromView(string $viewFile, array $data = []): void
    {
        // Extract data to variables
        extract($data);

        // Capture the output of the view file
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        $this->setBody($content);
    }

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
