<?php

require_once "autoload.php";
require_once __DIR__ . "/config/config.php";

use controllers\AuthController;
use controllers\SiteController;
use controllers\StudentController;
use core\Application;

$app = new Application($_SERVER["DOCUMENT_ROOT"], $config);


$app->router->get("/", [SiteController::class, "getDashboard"]);
$app->router->get("/index.php", [SiteController::class, "getDashboard"]);
$app->router->get("/login", [AuthController::class, "login"]);
$app->router->post("/login", [AuthController::class, "login"]);
$app->router->get("/logout", [AuthController::class, "logout"]);
$app->router->get("/alumnos", [StudentController::class, "getStudents"]);
$app->router->get("/alumnos/crear-alumno", [StudentController::class, "create"]);
$app->router->post("/alumnos/crear-alumno", [StudentController::class, "create"]);
$app->router->get("/alumnos/editar-alumno", [StudentController::class, "update"]);
$app->router->post("/alumnos/editar-alumno", [StudentController::class, "update"]);
$app->router->post("/alumnos/eliminar-alumno/:id", [StudentController::class, "delete"]);
$app->router->post("/clases", [ClassesController::class, "getClasses"]);

$app->run();