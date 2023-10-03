<?php

$this->title = "Crear Clase";

/**@var $model \models\Student */

foreach ($model as $key => $value) {
    $$key = $value;
}

?>

<div>
    <h1 class="mb-2">Lista de Clases</h1>
</div>

<div class="bg-white rounded">
    <div class="flex justify-between border border-gray-500 py-4 px-4">
        <h2>Informacion de las clases</h2>
        <a href="alumnos/crear-alumno">Agregar Clase</a>
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

<div class="fixed h-screen w-full top-0 left-0 flex items-center justify-center bg-[rgba(0,0,0,0.5)] z-50">
    <div class="w-full max-w-xs">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="post">
            <h2 class="mb-4">Agregar Clase</h2>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Nombre de la clase
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Nombre" name="name" value="<?php echo $name ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("name"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Maestro Asignado
                </label>
                <select name="id_teacher" id="teacher" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Sin asignar</option>
                    <?php foreach ($teachers as $teacher) : ?>
                        <option value="<?php echo $teacher["id"] ?>"><?php echo $teacher["firstname"] . " " . $teacher["lastname"] ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("name"); ?></p>
            </div>
            <div class="flex items-center justify-between">
                <a href="/clases">close</a>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Crear
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
    $("#classesTable").dataTable()
</script>