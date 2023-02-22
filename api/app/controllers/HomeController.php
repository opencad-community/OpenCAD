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
        $ocDescription = $config["app"]["oc_description"];
        $apiDescription = $config["app"]["api_description"];
        $ocGithub = $config["app"]["project_github"];
        $authorName = $config['app']['author']["name"];
        $authorEmail = $config["app"]["author"]["email"];
        $authorDiscord = $config["app"]["author"]["discord"];
        $authorGithub = $config["app"]["author"]["github"];

        // Return the data in a response
        $response = [
            'Version' => $version,
            'Title' => $title,
            'Description' => $ocDescription,
            'API Description' => $apiDescription,
            'GitHub' => $ocGithub,
            'Author' => [
                'Authors Name' => $authorName,
                "Authors Email" => $authorEmail,
                "Authors Discord" => $authorDiscord,
                "Authors GitHub" => $authorGithub
            ]
        ];
        $response = Response::success($response);
        $response->send();
    }
}
