<?php

require_once "autoload.php";
require_once __DIR__ . "/config/config.php";

use controllers\AuthController;
use controllers\ClassesController;
use controllers\SiteController;
use controllers\StudentController;
use controllers\TeacherController;
use controllers\UserController;
use core\Application;

$app = new Application($_SERVER["DOCUMENT_ROOT"], $config);


$app->router->get("/", [SiteController::class, "getDashboard"]);
$app->router->get("/index.php", [SiteController::class, "getDashboard"]);

$app->router->get("/usuarios/permisos", [UserController::class, "manageUsers"]);

$app->router->get("/login", [AuthController::class, "login"]);
$app->router->post("/login", [AuthController::class, "login"]);
$app->router->get("/logout", [AuthController::class, "logout"]);

$app->router->get("/alumnos", [StudentController::class, "getStudents"]);
$app->router->get("/alumnos/crear-alumno", [StudentController::class, "create"]);
$app->router->post("/alumnos/crear-alumno", [StudentController::class, "create"]);
$app->router->get("/alumnos/editar-alumno", [StudentController::class, "update"]);
$app->router->post("/alumnos/editar-alumno", [StudentController::class, "update"]);
$app->router->post("/alumnos/eliminar-alumno", [StudentController::class, "delete"]);

$app->router->get("/clases", [ClassesController::class, "getClasses"]);
$app->router->get("/clases/crear-clase", [ClassesController::class, "create"]);
$app->router->post("/clases/crear-clase", [ClassesController::class, "create"]);
$app->router->get("/clases/editar-clase", [ClassesController::class, "update"]);
$app->router->post("/clases/editar-clase", [ClassesController::class, "update"]);
$app->router->post("/clases/eliminar-clase", [ClassesController::class, "delete"]);

$app->router->get("/maestros", [TeacherController::class, "getTeachers"]);
$app->router->get("/maestros/crear-maestro", [TeacherController::class, "create"]);
$app->router->post("/maestros/crear-maestro", [TeacherController::class, "create"]);
$app->router->get("/maestros/editar-maestro", [TeacherController::class, "update"]);
$app->router->post("/maestros/editar-maestro", [TeacherController::class, "update"]);
$app->router->post("/maestros/eliminar-maestro", [TeacherController::class, "delete"]);

$app->run();