<?php

namespace App\Middlewares;

class TestMiddleware{
    public function handle(){
        error_log("Working");
    }
}