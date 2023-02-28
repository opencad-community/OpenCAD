<?php

namespace App\Controllers;

use Core\Response;
use Opencad\App\Helpers\Config\ConfigHandler;

class HomeController
{
    /**
     * The home method is used to display information about the API.
     *
     * @return void
     */
    public function index()
    {
        // Create an instance of ConfigHandler
        $config = new ConfigHandler();

        // Retrieve the configuration values using the get() method
        $version = $config->get('api', 'app.version');
        $title = $config->get('api', 'app.title');
        $ocDescription = $config->get('api', 'app.oc_description');
        $apiDescription = $config->get('api', 'app.api_description');
        $ocGithub = $config->get('api', 'app.project_github');
        $authorName = $config->get('api', 'app.author.name');
        $authorEmail = $config->get('api', 'app.author.email');
        $authorDiscord = $config->get('api', 'app.author.discord');
        $authorGithub = $config->get('api', 'app.author.github');

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
