<?php

namespace Core;

/**
 * The Request class is responsible for handling and processing incoming HTTP requests.
 * It provides methods for accessing information about the request,
 * such as the request method, URI, query parameters, and request body.
 */
class Request
{
    /**
     * The request method (e.g., GET, POST, PUT, DELETE).
     *
     * @var string
     */
    private $requestMethod;

    /**
     * The request URI.
     *
     * @var string
     */
    private $requestUri;

    /**
     * The query parameters.
     *
     * @var array
     */
    private $queryParams;

    /**
     * The request body, decoded as an associative array.
     *
     * @var array
     */
    private $requestBody;

    /**
     * Constructs a new Request instance.
     *
     * Initializes the request method,
     * request URI,
     * query parameters,
     * and request body properties based on information from the $_SERVER superglobal and the request body.
     */
    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->queryParams = $_GET;
        $this->requestBody = json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Returns the request method (e.g., GET, POST, PUT, DELETE).
     *
     * @return string The request method.
     */
    public function getMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * Returns the request URI.
     *
     * @return string The request URI.
     */
    public function getUri(): string
    {
        return $this->requestUri;
    }

    /**
     * Returns the query parameters.
     *
     * @return array The query parameters.
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Returns the value of a query parameter.
     *
     * @param string $name The name of the query parameter.
     *
     * @return mixed The value of the query parameter, or null if the parameter does not exist.
     */
    public function getQueryParam(string $name)
    {
        return $this->queryParams[$name] ?? null;
    }

    /**
     * Returns the request body as an associative array.
     *
     * @return array The request body.
     */
    public function getBody(): array
    {
        return $this->requestBody;
    }

    /**
     * Returns the value of a field in the request body.
     *
     * @param string $name The name of the field.
     *
     * @return mixed The value of the field, or null if the field does not exist.
     */
    public function getBodyField(string $name)
    {
        return $this->requestBody[$name] ?? null;
    }

    /**
     * Returns the request data as an associative array.
     * This method decodes the raw data from the request body as a JSON string
     * and returns it as an associative array.
     *
     * @return array The request data as an associative array.
     */
    public static function getData()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }

    /**
     * Get a header value from the request
     *
     * @param string $name The name of the header to get
     * @return string|null The value of the header, or null if the header is not present
     */
    public static function getHeader($name)
    {
        // Get all HTTP headers from the server environment
        $headers = getallheaders();

        // Check if the header is present and return its value
        if (isset($headers[$name])) {
            return $headers[$name];
        }

        // If the header is not present, return null
        return null;
    }
}