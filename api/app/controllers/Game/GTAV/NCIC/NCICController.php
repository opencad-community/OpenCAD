<?php

namespace App\Controllers\Game\GTAV\NCIC;

use Core\Request;
use Core\Response;
use App\Models\Game\GTAV\NCIC\NCICUser;
use App\Models\Game\GTAV\NCIC\NCICAttribute;
use App\Models\Game\GTAV\NCIC\NCICUserAttribute;
use Opencad\App\Helpers\Exceptions\Generic\InternalServerErrorException;

/**
 * The NCICController class is responsible for handling requests related to the
 * NCICUser,
 * NCICAttribute,
 * NCICUserAttribute models.
 *
 * @package App\Controllers\Game\GTAV\NCIC
 */
class NCICController
{
    /**
     * An instance of the NCICUser model to interact with the database.
     *
     * @var NCICUser
     */
    private $userModel;

    /**
     * An instance of the NCICAttribute model to interact with the database.
     *
     * @var NCICAttribute
     */
    private $attributeModel;

    /**
     * An instance of the NCICUserAttribute model to interact with the database.
     *
     * @var NCICUserAttribute
     */
    private $userAttributeModel;

    /**
     * Constructor to instantiate instances of the NCICUser, NCICAttribute, and NCICUserAttribute models.
     */
    public function __construct()
    {
        $this->userModel = new NCICUser();
        $this->attributeModel = new NCICAttribute();
        $this->userAttributeModel = new NCICUserAttribute();
    }

    /**
     * The index method is used to retrieve all NCIC users from the database.
     *
     * @return void
     */
    public function index()
    {
        try {
            // Get all NCIC users from the database using the NCICUser model
            $users = $this->userModel->getAllNCICUsers();
            if ($users) {
                // If the users were retrieved successfully, send a success response with the users data
                $response = Response::success($users);
                $response->send();
            } else {
                // If no users were found, send a not found response
                $response = Response::notFound("No NCIC users found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Show the information of a specific NCIC user
     *
     * @param int $id The ID of the NCIC user to show
     * @return void
     */
    /**
     * Retrieves NCIC user and their attributes from the database by user ID.
     *
     * @param int $id The ID of the user to retrieve.
     *
     * @return void
     */
    public function show($id)
    {
        try {
            // Get NCIC user information by User ID
            $user = $this->userModel->getNCICUserByUserId($id);
            // If user is found, send a success response with the user data
            if ($user) {
                // Retrieve all attributes for the user
                $attributes = $this->userAttributeModel->getAttributesForUser($user[0]["users_id"]);

                $attributesWithName = [];
                // Loop through the attributes and get their name from the attributes table
                foreach ($attributes as $attribute) {
                    $attributeWithName = $this->attributeModel->getAttributeById($attribute['attribute_id']);
                    if ($attributeWithName) {
                        $attribute['name'] = $attributeWithName[0]['id'];
                        $attributesWithName[] = $attribute;
                    }
                }
                // Add attributes to user data
                $user['attributes'] = $attributesWithName;


                // Send response with user data including attributes
                $response = Response::success($user);
                $response->send();
            } else {
                // If user is not found, send a not found response with a custom message

                $response = Response::notFound("NCIC user with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


    /**
     * Creates a new NCIC user
     *
     * This method creates a new NCIC user by getting the user data from the input and passing it to the addUser method
     * in the NCICUser model. If the user is successfully added,
     * a success response is sent with the message "NCIC user added
     * with ID {$id}" where {$id} is the ID of the newly added user. If there is an error, an exception is thrown and
     * a response with the error message is sent.
     *
     * @return void
     */
    public function addNcicUser()
    {
        try {
            // Get the user data from the input
            $data = Request::getData();

            // Pass the user data to the addUser method in the NCICUser model
            $id = $this->userModel->addNCICUser($data);

            // If the user is successfully added,
            // send a success response with the message "NCIC user added with ID {$id}"
            if ($id) {
                $response = Response::success("NCIC user added with ID {$id}");
                $response->send();
            } else {
                // If there is an error, send an error response with the message "Error adding NCIC user"
                $response = Response::error("Error adding NCIC user");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    public function createAttribute()
    {
        try {
            // Get the user data from the input
            $data = Request::getData();

            // Pass the user data to the addUser method in the NCICUser model
            $id = $this->attributeModel->addAttribute($data);

            // If the user is successfully added,
            // send a success response with the message "NCIC user added with ID {$id}"
            if ($id) {
                $response = Response::success("NCIC attribute added with ID {$id}");
                $response->send();
            } else {
                // If there is an error, send an error response with the message "Error adding NCIC user"
                $response = Response::error("Error adding NCIC attribute");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an existing NCIC user in the database
     *
     * @param int $id The ID of the NCIC user to be updated
     * @return void
     */
    public function update($id)
    {
        try {
            // Decode the incoming data from the request body
            $data = Request::getData();

            // Call the updateUser method from the NCICUser model to update the user
            $result = $this->userModel->updateNCICUser($id, $data);

            // If the update was successful, return a success response with a message
            if ($result) {
                $response = Response::success("NCIC user with ID {$id} updated");
                $response->send();
            } else {
                // If the update was not successful, return a not found response with an error message
                $response = Response::notFound("NCIC user with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Deletes a NCIC user from the database
     *
     * @param int $id The id of the NCIC user to delete
     * @return void
     */
    public function delete($id)
    {
        try {
            // Try to delete the user from the database
            $result = $this->userModel->deleteNCICUser($id);
            // If the user was deleted successfully
            if ($result) {
                // Delete all user attribute relationships for this user
                $this->userAttributeModel->deleteAllAttributesForUser($id);
                // Create a success response object with a message indicating that the user was deleted
                $response = Response::success("NCIC user with ID {$id} deleted");
                // Send the response to the client
                $response->send();
            } else {
                // If the user was not deleted,
                // create a not found response object with a message indicating that the user was not found
                $response = Response::notFound("NCIC user with ID {$id} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

    /**
     * Gets all the attributes for a specific NCIC user
     *
     * @param int $id The id of the NCIC user
     * @return void
     */
    public function showUserAttributes($id)
    {
        try {
            // Try to get all user attributes for this user
            $userAttributes = $this->userAttributeModel->getAttributesForUser($id);

            // If the user attributes were found, create a success response with the user attributes data
            if ($userAttributes) {
                $response = Response::success($userAttributes);
                $response->send();
            } else {
                // If the user attributes were not found, create a not found response with a custom message
                $response = Response::notFound("No attributes found for NCIC user with ID {$id}");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

    /**
     * Gets all the attributes.
     *
     * @param int $id The id of the NCIC user
     * @return void
     */
    public function showAttributes()
    {
        try {
            // Try to get all user attributes for this user
            $userAttributes = $this->attributeModel->getAllAttributes();

            // If the user attributes were found, create a success response with the user attributes data
            if ($userAttributes) {
                $response = Response::success($userAttributes);
                $response->send();
            } else {
                // If the user attributes were not found, create a not found response with a custom message
                $response = Response::notFound("No attributes found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

    /**
     * Adds an attribute for a specific NCIC user
     *
     * This method adds a new attribute to a specific NCIC user by getting the attribute data from the input and passing
     * it to the addUserAttribute method in the UserAttribute model. If the attribute is successfully added, a success
     * response is sent with message "Attribute added with ID {$id}" where {$id} is the ID of the newly added attribute.
     * If there is an error, an exception is thrown and a response with the error message is sent.
     *
     * @param int $id The id of the NCIC user
     * @return void
     */
    public function addAttribute($id)
    {
        try {
            // Get the attribute data from the input
            $data = Request::getData();

            // Pass the attribute data to the addUserAttribute method in the UserAttribute model
            $id = $this->userAttributeModel->addAttributeForUser($id, $data);

            // If the attribute is successfully added,
            // send a success response with the message "Attribute added with ID {$id}"
            if ($id) {
                $response = Response::success("Attribute added with ID {$id}");
                $response->send();
            } else {
                // If there is an error, send an error response with the message "Error adding attribute"
                $response = Response::error("Error adding attribute");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an attribute
     *
     * @param int $userId The ID of the NCIC user
     * @param int $attributeId The ID of the attribute to be updated
     * @return void
     */
    public function updateAttribute($attributeId)
    {
        try {
            // Decode the incoming data from the request body
            $data = Request::getData();

            // Call the updateUserAttribute method from the user attribute model to update the attribute
            $result = $this->attributeModel->updateAttribute($attributeId, $data);

            // If the update was successful, return a success response with a message
            if ($result) {
                $response = Response::success("Attribute with ID {$attributeId} updated");
                $response->send();
            } else {
                // If the update was not successful, return a not found response with an error message
                $response = Response::notFound("Attribute with ID {$attributeId} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // Catch any exceptions thrown and return an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an attribute for a specific NCIC user
     *
     * @param int $userId The ID of the NCIC user
     * @param int $attributeId The ID of the attribute to be updated
     * @return void
     */
    public function updateUserAttribute($userId, $attributeId)
    {
        try {
            // Decode the incoming data from the request body
            $data = Request::getData();

            // Call the updateUserAttribute method from the user attribute model to update the attribute
            $result = $this->userAttributeModel->updateAttributeForUser($userId, $attributeId, $data);

            // If the update was successful, return a success response with a message
            if ($result) {
                $response = Response::success(
                    "Attribute with ID {$attributeId} for NCIC user with ID {$userId} updated"
                );
                $response->send();
            } else {
                // If the update was not successful, return a not found response with an error message
                $response = Response::notFound(
                    "Attribute with ID {$attributeId} for NCIC user with ID {$userId} not found"
                );
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // Catch any exceptions thrown and return an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Deletes an attribute from a specific NCIC user
     *
     * @param int $userId The id of the NCIC user
     * @param int $attributeId The id of the attribute to delete
     * @return void
     */
    public function deleteUserAttribute($userId, $attributeId)
    {
        try {
            // Try to delete the attribute from the database
            $result = $this->userAttributeModel->deleteAttributeForUser($userId, $attributeId);
            // If the attribute was deleted successfully
            if ($result) {
                // Create a success response object with a message indicating that the attribute was deleted
                $response = Response::success(
                    "Attribute with ID {$attributeId} for NCIC user with ID {$userId} deleted"
                );
                // Send the response to the client
                $response->send();
            } else {
                // If the attribute was not deleted,
                // create a not found response object with a message indicating that the attribute was not found
                $response = Response::notFound(
                    "Attribute with ID {$attributeId} for NCIC user with ID {$userId} not found"
                );
                // Send the response to the client
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

    /**
     * Deletes an attribute from a specific NCIC user
     *
     * @param int $userId The id of the NCIC user
     * @param int $attributeId The id of the attribute to delete
     * @return void
     */
    public function deleteAttribute($attributeId)
    {
        try {
            // Try to delete the attribute from the database
            $result = $this->attributeModel->deleteAttribute($attributeId);
            // If the attribute was deleted successfully
            if ($result) {
                // Create a success response object with a message indicating that the attribute was deleted
                $response = Response::success("Attribute with ID {$attributeId} deleted");
                // Send the response to the client
                $response->send();
            } else {
                // If the attribute was not deleted,
                // create a not found response object with a message indicating that the attribute was not found
                $response = Response::notFound("Attribute with ID {$attributeId} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If a database error occurred, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }
}
