<?php

spl_autoload_register(function($class) {
    include 'controllers/' . $class . '.php';
});

?>