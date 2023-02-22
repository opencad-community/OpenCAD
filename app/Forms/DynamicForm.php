<?php
namespace Opencad\App\Forms;

use Exception;

class DynamicForm {
    private $fields = [];
    private $action;
    private $method;
    private $csrfToken;

    public function __construct($action = '', $method = 'post') {
        $this->action = $action;
        $this->method = $method;
        $this->csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $this->csrfToken;
    }

    public function addField($name, $type, $options = []) {
        $this->fields[] = [
            'name' => $name,
            'type' => $type,
            'options' => $options,
        ];
    }

    public function render() {
        $html = '<form action="' . $this->action . '" method="' . $this->method . '">';
        $html .= '<input type="hidden" name="csrf_token" value="' . $this->csrfToken . '">';

        foreach ($this->fields as $field) {
            $html .= '<div>';

            switch ($field['type']) {
                case 'text':
                    $html .= '<label for="' . $field['name'] . '">' . ucfirst($field['name']) . '</label>';
                    $html .= '<input type="text" name="' . $field['name'] . '" id="' . $field['name'] . '">';
                    break;
                case 'email':
                    $html .= '<label for="' . $field['name'] . '">' . ucfirst($field['name']) . '</label>';
                    $html .= '<input type="email" name="' . $field['name'] . '" id="' . $field['name'] . '">';
                    break;
                case 'select':
                    $html .= '<label for="' . $field['name'] . '">' . ucfirst($field['name']) . '</label>';
                    $html .= '<select name="' . $field['name'] . '" id="' . $field['name'] . '">';

                    foreach ($field['options'] as $option) {
                        $html .= '<option value="' . $option . '">' . $option . '</option>';
                    }

                    $html .= '</select>';
                    break;
                case 'checkbox':
                    $html .= '<input type="checkbox" name="' . $field['name'] . '" id="' . $field['name'] . '">';
                    $html .= '<label for="' . $field['name'] . '">' . ucfirst($field['name']) . '</label>';
                    break;
            }

            $html .= '</div>';
        }

        $html .= '<button type="submit">Submit</button></form>';

        echo $html;
    }

    public function handleData() {
        if (strtolower($_SERVER['REQUEST_METHOD']) !== $this->method) {
            throw new Exception('Invalid request method');
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $this->csrfToken) {
            throw new Exception('CSRF token validation failed');
        }

        $data = [];

        foreach ($this->fields as $field) {
           htmlspecialchars($data[$field['name']] = isset($_POST[$field['name']]) ? $_POST[$field['name']] : null);
        }

        return $data;
    }
}
