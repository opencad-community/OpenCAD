<?php

namespace App\Controllers\Game\GTAV\Citations;

use Exception;
use Core\Request;
use PDOException;
use Core\Response;
use App\Models\Game\GTAV\Citations\CitationsModel;
use Opencad\App\Helpers\Exceptions\Generic\InternalServerErrorException;

class CitationsController
{
    private $citationModel;
    
    public function __construct()
    {
        $this->citationModel = new CitationsModel();
    }

    /**
     * Retrieve all citations from the database.
     */
    public function index()
    {
        try {
            $citations = $this->citationModel->getAllCitations();
            if ($citations) {
                $response = Response::success($citations);
                $response->send();
            } else {
                $response = Response::notFound("No citations found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Show the information of a specific citation.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        try {
            $citation = $this->citationModel->getCitationById($id);

            if ($citation) {
                $response = Response::success($citation);
                $response->send();
            } else {
                $response = Response::notFound("Citation with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Creates a new citation.
     *
     * @return void
     */
    public function create()
    {
        try {
            $data = Request::getData();

            $id = $this->citationModel->addCitation($data);

            if ($id) {
                $response = Response::success("Citation added with ID {$id}");
                $response->send();
            } else {
                $response = Response::error("Error adding citation");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an existing citation in the database.
     *
     * @param int $id The ID of the citation to be updated
     * @return void
     */
    public function update($id)
    {
        try {
            $data = Request::getData();

            $result = $this->citationModel->updateCitation($id, $data);

            if ($result) {
                $response = Response::success("Citation with ID {$id} updated");
                $response->send();
            } else {
                $response = Response::notFound("Citation with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }
    /**
     * Deletes a citation from the database.
     *
     * @param int $id The ID of the citation to delete
     * @return void
     */
    public function delete($id)
    {
        try {
            // Try to delete the citation from the database
            $result = $this->citationModel->deleteCitation($id);
            // If the citation was deleted successfully
            if ($result) {
                // Create a success response object with a message indicating that the citation was deleted
                $response = Response::success("Citation with ID {$id} deleted");
                // Send the response to the client
                $response->send();
            } else {
                // If the citation was not deleted,
                // create a not found response object with a message indicating that the citation was not found
                $response = Response::notFound("Citation with ID {$id} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception was thrown, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }
}