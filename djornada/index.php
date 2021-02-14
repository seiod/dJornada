<?php
session_start();

require_once 'autoload.php';

require_once 'vendor/autoload.php';

require_once 'config/db.php';

require_once 'config/parameters.php';

require_once 'helpers/utils.php';

require_once 'views/layout/cabecera.php';

function showError() {
    $error = new errorController();
    $error->index();
}

if (isset($_GET['controller'])) {
    $controller_name = $_GET['controller'].'Controller';
    
    if (class_exists($controller_name)) {
        $controller = new $controller_name();
        
        if (isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
            $action = $_GET['action'];
            $controller->$action();
        } else {
            showError();
        }
    } else {
        showError();
    }
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $controller_name = controller_default;
    $controller = new $controller_name();

    $action_default = action_default;

    $controller->$action_default();
} else {
    showError();
}

require_once 'views/layout/footer.php';
?>