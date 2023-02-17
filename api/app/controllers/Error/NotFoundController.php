<?php

namespace App\Controllers\Error;

use Core\Response;

class NotFoundController
{
    /**
     * Show a 404 Not Found error page
     *
     * @return void
     */
    public function index()
    {
        $response = Response::error("The requested resource could not be found!");
        $response->send();
    }
}