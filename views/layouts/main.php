<?php

use core\Application;


$user = Application::$app->session->get("user");
$userRolDisplay;

switch ($user["rol"]) {
    case 'ADMIN':
        $userRolDisplay = "Administrador";
        break;
    case 'TEACHER':
        $userRolDisplay = "Maestro";
        break;
    case 'STUDENT':
        $userRolDisplay = "Alumno";
        break;
    default:
        $userRolDisplay = "Rol Desconocido";
        break;
}

$breadcrumbs = explode("/", $_SERVER["REQUEST_URI"]);


$path = $_SERVER["PATH_INFO"] ?? "/";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../../dist/output.css">

</head>

<body class="text-gray-800 font-inter">
    <!-- Start: sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4">

        <a href="" class="flex items-center pb-4 border-b border-b-gray-600">
            <img src="./../../assets/logo-aside.jpg" alt="logo-universidad" class="w-10 h-10 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3">Universidad</span>
        </a>
        <div class="flex flex-col py-4 border-b border-b-gray-600">
            <p class="text-white"><?php echo $userRolDisplay ?></p>
            <p class="text-white text-sm"><?php echo $user["name"] ?></p>
        </div>
        <ul class="mt-4">
            <?php if ($user["rol"] === "ADMIN") : ?>
                <li class="mb-1 group sidebar-button <?php if($path === "/") echo "active" ?>">
                    <a href="usuarios/permisos" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-600 group-[.active]:text-white">
                        <span class="material-symbols-outlined text-white mr-3 text-lg">
                            manage_accounts
                        </span>
                        <span class="text-sm flex items-center">Permisos</span>
                    </a>
                </li>
                <li class="mb-1 group sidebar-button <?php if($path === "/maestros") echo "active" ?>">
                    <a href="/maestros" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-600 group-[.active]:text-white">
                        <span class="material-symbols-outlined text-white mr-3 text-lg">
                            interactive_space
                        </span>
                        <span class="text-sm flex items-center">Maestros</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user["rol"] === "ADMIN" or $user["rol"] === "TEACHER") : ?>
                <li class="mb-1 group sidebar-button <?php if($path === "/alumnos") echo "active" ?>">
                    <a href="/alumnos" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-600 group-[.active]:text-white">
                        <span class="material-symbols-outlined text-white mr-3 text-lg">
                            school
                        </span>
                        <span class="text-sm flex items-center">Alumnos</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user["rol"] === "ADMIN") : ?>
                <li class="mb-1 group sidebar-button <?php if($path === "/clases") echo "active" ?>">
                    <a href="/clases" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-600 group-[.active]:text-white">
                        <span class="material-symbols-outlined text-white mr-3 text-lg">
                            cast_for_education
                        </span>
                        <span class="text-sm flex items-center">Clases</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user["rol"] === "STUDENT") : ?>
                <li class="mb-1 group sidebar-button">
                    <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-600 group-[.active]:text-white">
                        <span class="material-symbols-outlined text-white mr-3 text-lg">
                            task
                        </span>
                        <span class="text-sm flex items-center">Ver Calificaciones</span>
                    </a>
                </li>
                <li class="mb-1 group sidebar-button">
                    <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-600 group-[.active]:text-white">
                        <span class="material-symbols-outlined text-white mr-3 text-lg">
                            team_dashboard
                        </span>
                        <span class="text-sm flex items-center">Administra tus Clases</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- End: sidebar -->
    <!-- start: main -->
    <main class="w-[cal(100%-256px)] ml-64 relative">
        <div class="py-2 px-4 bg-white flex items-center drop-shadow-lg">
            <button type="button" class="text-lg text-gray-600 flex items-center">
                <span class="material-symbols-outlined">
                    menu
                </span>
            </button>
            <ul class="flex items-center text-sm ml-4">
                <li class="mr-2">
                    <a href="/" class="text-gray-400 hover:text-gray-600 font-medium">Dashboard</a>
                </li>
                <?php if ($breadcrumbs) : ?>
                    <?php foreach ($breadcrumbs as $endpoint) : ?>
                        <?php if ($endpoint === "") {
                            continue;
                        } ?>
                        <li class="text-gray-600 mr2 font-medium">/</li>
                        <li class="text-gray-600 mr2 font-medium"><?php echo $endpoint ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <ul class="ml-auto flex items-center">
                <li class="relative group" id="dropdown">
                    <button id="menu-open-toggle" type="button" class="flex items-center">
                        <img src="./../../assets/user_image_placeholder.png" alt="user-image-placeholer" class="w-8 h-8 rounded block object-cover align-middle mr-4">
                        <span class="mr-4"><?php echo $user["name"] ?></span>
                        <span class="material-symbols-outlined group-[.menu-open]:rotate-90">
                            chevron_right
                        </span>
                    </button>
                    <ul id="dropdown-menu" class="absolute hidden py-2 px-4 rounded-md bg-white border border-gray-100 mt-2">
                        <li class="flex px-2">
                            <a href="/logout" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">
                                <span class="material-symbols-outlined text-red-700">
                                    logout
                                </span>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="p-6 bg-slate-200 h-screen">
            {{content}}
        </div>
    </main>
    <!-- end: main -->
    <script src="./../../dist/js/dashboard.js"></script>
</body>

</html>