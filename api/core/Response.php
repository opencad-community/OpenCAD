<?php

namespace  Core;
class Response
{
    /**
     * The HTTP status code for the response.
     *
     * @var int
     */
    private $statusCode;

    /**
     * The data to be sent in the response.
     *
     * @var mixed
     */
    private $data;

    /**
     * Creates a new response instance.
     *
     * @param int $statusCode The HTTP status code for the response.
     * @param mixed $data The data to be sent in the response.
     */
    public function __construct(int $statusCode, $data)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    /**
     * Sends the response to the client.
     */
    public function send()
    {
        http_response_code($this->statusCode);
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }

    /**
     * Creates a new success response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function success($data = null)
    {
        return new self(200, $data);
    }

    /**
     * Creates a new error response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function error($data = null)
    {
        return new self(400, $data);
    }
}
