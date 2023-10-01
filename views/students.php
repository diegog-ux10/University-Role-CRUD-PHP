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
                            <a href="<?php "alumno/eliminar-alumno?id=$id" ?>">
                                <span class="material-symbols-outlined text-red-600">
                                    delete
                                </span>
                            </a>
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