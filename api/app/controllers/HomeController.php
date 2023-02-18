<?php

namespace App\Controllers;

use Core\Response;

class HomeController
{
    /**
     * The home method is used to display information about the API.
     *
     * @return void
     */
    public function index()
    {
        // Load the configuration file
        $config = require_once __DIR__ . '/../../config/config.php';

        // Extract the relevant data from the configuration file
        $version = $config['app']['version'];
        $title = $config['app']['title'];
        $oc_description = $config["app"]["oc_description"];
        $api_description = $config["app"]["api_description"];
        $oc_github = $config["app"]["project_github"];
        $author_name = $config['app']['author']["name"];
        $author_email = $config["app"]["author"]["email"];
        $author_discord = $config["app"]["author"]["discord"];
        $author_github = $config["app"]["author"]["github"];

        // Return the data in a response
        $response = [
            'Version' => $version,
            'Title' => $title,
            'Description' => $oc_description,
            'API Description' => $api_description,
            'GitHub' => $oc_github,
            'Author' => [
                'Authors Name' => $author_name,
                "Authors Email" => $author_email,
                "Authors Discord" => $author_discord,
                "Authors GitHub" => $author_github
            ]
        ];
        $response = Response::success($response);
        $response->send();
    }
}