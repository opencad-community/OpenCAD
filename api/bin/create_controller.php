<?php

if ($argc < 2) {
    echo "Usage: php create_controller.php ControllerName\n";
    exit(1);
}

$controllerName = $argv[1];

$file = "<?php

namespace App\Controllers;

class $controllerName
{
    public function __construct(){
        
    }

    public function index()
    {
        // Placeholder method
    }
}
";

file_put_contents("app/controllers/$controllerName.php", $file);

echo "Controller $controllerName created successfully.\n";

