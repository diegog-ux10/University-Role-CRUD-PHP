<?php
foreach ($model as $key => $value) {
    $$key = $value;
}
?>

<div>
    <h1 class="mb-2">Editar datos de perfil</h1>
</div>
<div class="w-full">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="post">
        <h2>Informacion del Usuario</h2>
        <div class="my-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Correo Electronico
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Igresa tu email" name="email" value="<?php echo $email ?>">
            <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("email"); ?></p>
        </div>
        <div class="my-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Contraseña
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Igresa tu password" name="password" value="<?php echo $password ?>">
            <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError("password"); ?></p>
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
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>