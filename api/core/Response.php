<?php

namespace Core;

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

    /**
     * Creates a new created response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function created($data = null)
    {
        return new self(201, $data);
    }

    /**
     * Creates a new accepted response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function accepted($data = null)
    {
        return new self(202, $data);
    }

    /**
     * Creates a new no content response.
     *
     * @return Response
     */
    public static function noContent()
    {
        return new self(204, null);
    }

    /**
     * Creates a new bad request response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function badRequest($data = null)
    {
        return new self(400, $data);
    }

    /**
     * Creates a new unauthorized response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function unauthorized($data = null)
    {
        return new self(401, $data);
    }

    /**
     * Creates a new forbidden response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function forbidden($data = null)
    {
        return new self(403, $data);
    }

    /**
     * Creates a new not found response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function notFound($data = null)
    {
        return new self(404, $data);
    }

    /**
     * Creates a new conflict response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function conflict($data = null)
    {
        return new self(409, $data);
    }

    /**
     * Creates a new internal server error response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function internalServerError($data = null)
    {
        return new self(500, $data);
    }

    /**
     * Creates a new not implemented response.
     *
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function notImplemented($data = null)
    {
        return new self(501, $data);
    }

    /**
     * Creates a new custom response with a specified HTTP status code.
     *
     * @param int $statusCode The HTTP status code for the response.
     * @param mixed $data The data to be sent in the response.
     * @return Response
     */
    public static function custom(int $statusCode, $data = null)
    {
        return new self($statusCode, $data);
    }
}
