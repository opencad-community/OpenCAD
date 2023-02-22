<?php
namespace Opencad\App\Helpers\Exceptions;

// Define the base exception class that defines the custom styling and exception handler
class BaseException extends \Exception
{
    public function __toString()
    {
        ob_start();
        echo $this->getExceptionHtml();
        return ob_get_clean();
    }

    public function getStyledMessage()
    {
        return $this->getExceptionHtml();
    }

    public function getBasicMessage()
    {
        $html = '<div style="font-family: sans-serif; background-color: #FDD; border: 1px solid #F00; padding: 10px;">';
        $html .= '<h1 style="font-size: 1.2em; font-weight: bold;
        margin: 0;">Oops! Something went wrong on our end. Please try again later.</h1>';
        $html .= '</div>';
        return $html;
    }

    protected function getExceptionHtml()
    {
        $html = '<div style="font-family: sans-serif; background-color: #FDD;';
        $html .= 'border: 1px solid #F00; padding: 10px;">';
        $html .= '<h1 style="font-size: 1.2em; font-weight: bold; margin: 0;">' . $this->getMessage() . '</h1>';
        $html .= '<p style="margin: 0;">' . $this->getFile() . ' on line ' . $this->getLine() . '</p>';
        $html .= '<pre style="font-size: 0.8em;
        margin: 10px 0;
        padding: 10px;
        background-color: #EEE;">' . $this->getTraceAsString() . '</pre>';
        $html .= '</div>';

        return $html;
    }
    public static function exceptionHandler($exception)
    {
        // Log the exception message and stack trace to a file
        $logFile =  __DIR__ . '/../../../bin/logs/exception.log';
        $logMessage = "Exception: " . $exception->getMessage() . "\n";
        $logMessage .= "Stack trace: " . $exception->getTraceAsString() . "\n";
        $logMessage .= "File: " . $exception->getFile() . "\n";
        $logMessage .= "Line: " . $exception->getLine() . "\n";
        $logMessage .= "Logged Date Time: " . date("Y-m-d H:i:s") . "\n";

        error_log($logMessage, 3, $logFile);

        // Display a friendly error message to the user
        if (error_reporting() == 0) {
            // Error reporting is disabled, display a generic error message
            $friendlyMessage = $exception->getBasicMessage();
        } else {
            // Error reporting is enabled, display the exception message and stack trace
            $friendlyMessage = $exception->getStyledMessage();
        }
        http_response_code(500);
        echo $friendlyMessage;

        // End the script execution
        exit;
    }
}

// Set the custom exception handler function
set_exception_handler(['Opencad\App\Helpers\Exceptions\BaseException', 'exceptionHandler']);
