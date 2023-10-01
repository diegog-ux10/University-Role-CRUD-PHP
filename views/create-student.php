<?php

$this->title = "Crear Alumno";

/**@var $model \models\Student */

foreach ($model as $key => $value) {
    $$key = $value;
}


?>


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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="fixed h-screen w-full top-0 left-0 flex items-center justify-center bg-[rgba(0,0,0,0.5)] z-50">
    <div class="w-full max-w-xs">
        <h2>Agregar Alumno</h2>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="dni">
                    DNI
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="dni" type="text" placeholder="DNI" name="dni" value="<?php echo $dni ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("dni"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Correo Electronico
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Correo Electronico" name="email" value="<?php echo $email ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("email"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">
                    Nombre(s)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstname" type="text" placeholder="Nombre" name="firstname" value="<?php echo $firstname ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("firstname"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">
                    Apellido(s)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastname" type="text" placeholder="Apellido" name="lastname" value="<?php echo $lastname ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("lastname"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                    Dirección
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" type="text" placeholder="Direccion" name="address" value="<?php echo $address ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("address"); ?></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bday">
                    Fecha de Nacimiento
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bday" type="date" placeholder="Fecha de Nacimiento" name="bday" value="<?php echo $bday ?>">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("bday"); ?></p>
            </div>
            <div class="flex items-center justify-between">
                <a href="/alumnos">close</a>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Crear
                </button>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy;2020 Acme Corp. All rights reserved.
        </p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $("#example").dataTable()
</script>