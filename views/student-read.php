<?php

use core\Application;


$user = Application::$app->session->get("user");

?>

<!-- START: VISTA PARA ADMIN -->

<?php if ($user["rol"] === "ADMIN") : ?>
    <div>
        <h1 class="mb-2">Lista de Alumnos</h1>
    </div>

    <div class="bg-white rounded">
        <div class="flex justify-between border border-gray-500 py-4 px-4">
            <h2>Informacion de Alumnos</h2>
            <a href="alumnos/crear-alumno">Agregar Alumno</a>
        </div>
        <div class="border border-gray-500 py-3 px-4">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Correo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Direccion</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) : ?>
                        <tr>
                            <td><?php echo $student["id"] ?></td>
                            <td><?php echo $student["dni"] ?></td>
                            <td><?php echo $student["email"] ?></td>
                            <td><?php echo $student["firstname"] ?></td>
                            <td><?php echo $student["lastname"] ?></td>
                            <td><?php echo $student["address"] ?></td>
                            <td><?php echo $student["bday"] ?></td>
                            <td class="flex gap-4">
                                <a href="<?php echo "alumnos/editar-alumno?id=" .  $student["id"] ?>">
                                    <span class="material-symbols-outlined text-blue-600">
                                        edit
                                    </span>
                                </a>
                                <div>
                                    <form action="alumnos/eliminar-alumno" method="post">
                                        <input type="number" name="id" value="<?php echo $student["id"] ?>" hidden>
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
<!-- END: VISTA PARA ADMIN -->


<?php if ($user["rol"] === "TEACHER") : ?>
    <div>
        <h1 class="mb-2">Alumnos de la clase de <?php echo $user['fullName'] ?></h1>
    </div>

    <div class="bg-white rounded">
        <div class="flex justify-between border border-gray-500 py-4 px-4">
            <h2>Alumnos de la clase de <?php echo $user['fullName'] ?></h2>
        </div>
        <div class="border border-gray-500 py-3 px-4">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de alumno</th>
                        <th>Calificación</th>
                        <th>Mensajes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assignedStudents as $student) : ?>
                        <tr>
                            <td><?php echo $student->id ?></td>
                            <td><?php echo $student->firstname . " " .  $student->lastname ?></td>
                            <td><?php echo "no calificacion" ?></td>
                            <td><?php echo "No hay Mensajes" ?></td>
                            <td class="flex justify-center gap-4">
                                <a href="<?php echo "alumnos/editar-alumno?id=" .  $student->id ?>">
                                    <span class="material-symbols-outlined text-blue-600">
                                        grading
                                    </span>
                                </a>
                                <div>
                                    <form action="alumnos/eliminar-alumno" method="post">
                                        <input type="number" name="id" value="<?php echo $student->id ?>" hidden>
                                        <button type="submit">
                                            <span class="material-symbols-outlined text-blue-600">
                                                send
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $("#example").dataTable()
</script>