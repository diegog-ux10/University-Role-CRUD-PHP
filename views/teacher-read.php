<?php

use core\Application;

$user = Application::$app->session->get("user");
if ($user["rol"] !== "ADMIN") {
    Application::$app->response->redirect("/unauthorized");
}
?>
<div>
    <h1 class="mb-2">Lista de Maestros</h1>
</div>

<div class="bg-white rounded">
    <div class="flex justify-between border border-gray-500 py-4 px-4">
        <h2>Informacion de Maestros</h2>
        <a href="maestros/crear-maestro">Agregar Maestro</a>
    </div>
    <div class="border border-gray-500 py-3 px-4">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Clase Asignada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $teacher) : ?>
                    <tr>
                        <td><?php echo $teacher["id"] ?></td>
                        <td><?php echo $teacher["name"] ?></td>
                        <td><?php echo $teacher["email"] ?></td>
                        <td><?php echo $teacher["address"] ?></td>
                        <td><?php echo $teacher["bday"] ?></td>
                        <td><?php echo $teacher["assigned_class"] ?></td>
                        <td class="flex gap-4">
                            <a href="<?php echo "maestros/editar-maestro?id=" .  $teacher["id"] ?>">
                                <span class="material-symbols-outlined text-blue-600">
                                    edit
                                </span>
                            </a>
                            <div>
                                <form action="maestros/eliminar-maestro" method="post">
                                    <input type="number" name="id" value="<?php echo $teacher["id"] ?>" hidden>
                                    <button type="submit">
                                        <span class="material-symbols-outlined text-red-600">
                                            delete
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $("#example").dataTable()
</script>