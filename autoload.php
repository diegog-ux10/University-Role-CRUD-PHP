<?php
spl_autoload_register(function ($className) {
    include dirname(__FILE__) . '/' . str_replace("\\", "/", $className) . ".php";
    // echo "Autoloaded class: " . $className.PHP_EOL;
});
