<?php

use core\Application;


$user = Application::$app->session->get("user");



?>

<?php if ($user["rol"] === "ADMIN") : ?>
    <div>
        <h1 class="mb-2">Lista de Clases</h1>
    </div>

    <div class="bg-white rounded">
        <div class="flex justify-between border border-gray-500 py-4 px-4">
            <h2>Informacion de las clases</h2>
            <a href="clases/crear-clase">Agregar Clase</a>
        </div>
        <div class="border border-gray-500 py-3 px-4">
            <table id="classesTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Clase</th>
                        <th>Maestro</th>
                        <th>Alumnos Inscritos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $class) : ?>
                        <tr>
                            <td><?php echo $class["id"] ?></td>
                            <td><?php echo $class["name"] ?></td>
                            <td><?php echo $class["teacher"] ?></td>
                            <td><?php echo $class["enrolled_students"] ?></td>
                            <td class="flex gap-4">
                                <a href="<?php echo "clases/editar-clase?id=" .  $class["id"] ?>">
                                    <span class="material-symbols-outlined text-blue-600">
                                        edit
                                    </span>
                                </a>
                                <div>
                                    <form action="clases/eliminar-clase" method="post">
                                        <input type="number" name="id" value="<?php echo $class["id"] ?>" hidden>
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
<?php endif; ?>
<?php if ($user["rol"] === "STUDENT") : ?>
    <div>
        <h1 class="mb-2">Calificaciones y Mensajes de tus Clases</h1>
    </div>

    <div class="bg-white rounded">
        <div class="flex justify-between border border-gray-500 py-4 px-4">
            <h2>Calificaciones y Mensajes de tus Clases</h2>
        </div>
        <div class="border border-gray-500 py-3 px-4">
            <table id="classesTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre de Clase</th>
                        <th>Calificacion</th>
                        <th>Mensajes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrolledClasses["enrolled_classes"] as $class) : ?>
                        <tr>
                            <td><?php echo $class["id"] ?></td>
                            <td><?php echo $class["name"] ?></td>
                            <td><?php echo $class["grade"] ?></td>
                            <td><?php echo 'No hay Mensajes' ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $("#classesTable").dataTable()
</script>