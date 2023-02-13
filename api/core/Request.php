<?php
namespace  Core;
class Request {
    private $requestMethod;
    private $requestUri;
    private $queryParams;
    private $requestBody;

    public function __construct() {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->queryParams = $_GET;
        $this->requestBody = json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Returns the request method (e.g., GET, POST, PUT, DELETE).
     */
    public function getMethod(): string {
        return $this->requestMethod;
    }

    /**
     * Returns the request URI.
     */
    public function getUri(): string {
        return $this->requestUri;
    }

    /**
     * Returns the query parameters.
     */
    public function getQueryParams(): array {
        return $this->queryParams;
    }

    /**
     * Returns the value of a query parameter.
     */
    public function getQueryParam(string $name) {
        return $this->queryParams[$name] ?? null;
    }

    /**
     * Returns the request body as an associative array.
     */
    public function getBody(): array {
        return $this->requestBody;
    }

    /**
     * Returns the value of a field in the request body.
     */
    public function getBodyField(string $name) {
        return $this->requestBody[$name] ?? null;
    }
}
