<?php

use core\Application;

foreach ($model as $key => $value) {
    $$key = $value;
}
$user = Application::$app->session->get("user");
if ($user["rol"] !== "ADMIN") {
    Application::$app->response->redirect("/unauthorized");
}
?>

<div>
    <h1 class="mb-2">Lista de Permisos</h1>
</div>

<div class="bg-white rounded">
    <div class="flex justify-between border border-gray-500 py-4 px-4">
        <h2>Informacion de Permisos</h2>
    </div>
    <div class="border border-gray-500 py-3 px-4">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email/Usuario</th>
                    <th>Permiso</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $user["id"] ?></td>
                        <td><?php echo $user["email"] ?></td>
                        <td>
                            <?php
                            $userRole = $user["id_role"];
                            switch ($userRole) {
                                case 1:
                                    echo "<div class='flex justify-center items-center py-0.5 w-21 rounded-full bg-yellow-400 text-base text-white font-medium'>
                                            <span class='material-symbols-outlined'>
                                                shield_person
                                            </span>
                                             <div class='text-xs font-normal'>Administrador</div>
                                          </div>";
                                    break;
                                case 2:
                                    echo "<div class='flex justify-center items-center py-0.5 w-21 rounded-full bg-blue-500 text-base text-white font-medium'>
                                            <span class='material-symbols-outlined'>
                                                contacts
                                            </span>
                                             <div class='text-xs font-normal'>Maestro</div>
                                          </div>";
                                    break;
                                case 3:
                                    echo "<div class='flex justify-center items-center py-0.5 w-21 rounded-full bg-gray-900 text-base text-white font-medium'>
                                            <span class='material-symbols-outlined'>
                                                face
                                            </span>
                                             <div class='text-xs font-normal'>Alumno</div>
                                          </div>";
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $userStatus = $user["id_status"];
                            switch ($userStatus) {
                                case 1:
                                    echo "<div class='flex justify-center items-center py-0.5 w-20 rounded-full bg-green-700 text-base text-white font-medium'>
                                             <div class='text-xs font-normal'>Activo</div>
                                          </div>";
                                    break;
                                case 2:
                                    echo "<div class='flex justify-center items-center py-0.5 w-20 rounded-full bg-red-700 text-base text-white font-medium'>
                                             <div class='text-xs font-normal'>Inactivo</div>
                                          </div>";
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            ?>
                        </td>
                        <td class="flex justify-center">
                            <a href="<?php echo "permisos/editar-permisos?id=" .  $user["id"] ?>">
                                <span class="material-symbols-outlined text-blue-600">
                                    edit
                                </span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<div class="fixed h-screen w-full top-0 left-0 flex items-center justify-center bg-[rgba(0,0,0,0.5)] z-50">
    <div class="w-full max-w-md">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="post">
            <h2 class="mb-4">Editar Permiso</h2>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email del Usuario
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Nombre" name="email" value="<?php echo $email ?>" disabled>
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("email"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="rol">
                    Rol del Usuario
                </label>
                <select name="id_role" id="rol" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="1">admin</option>
                    <option value="2">maestro</option>
                    <option value="3">alumno</option>
                </select>
            </div>
            <div class="flex">
                <div class="flex items-center mr-4 mb-4">
                    <input id="active" type="radio" name="id_status" class="hidden" value="1" checked />
                    <label for="active" class="flex items-center cursor-pointer">
                        <span class="w-4 h-4 inline-block mr-1 rounded-full border border-grey"></span>
                        Activo</label>
                </div>

                <div class="flex items-center mr-4 mb-4">
                    <input id="inactive" type="radio" name="id_status" class="hidden" value="2" />
                    <label for="inactive" class="flex items-center cursor-pointer">
                        <span class="w-4 h-4 inline-block mr-1 rounded-full border border-grey"></span>
                        Inactive</label>
                </div>
            </div>

            <input type="number" name="id" value="<?php echo $id ?>" hidden>
            <div class="flex items-center justify-between">
                <a href="/permisos" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">close</a>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $("#example").dataTable()
</script>