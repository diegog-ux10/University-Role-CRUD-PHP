<?php

$this->title = "Login";

/**@var $model \models\User */

foreach ($model as $key => $value) {
    $$key = $value;
}


?>

<div class="bg-gradient-to-tr from-blue-400 to-indigo-900 h-screen w-full flex justify-center items-center">
    <div class="w-full sm:w-1/2 md:w-9/12 lg:w-1/2 shadow-md flex flex-col md:flex-row items-center mx-5 sm:m-0 rounded">
        <div class="bg-[#FFF5D2] w-full md:w-1/2 hidden md:flex flex-col justify-center items-center text-white">
            <img src="./../assets/logo.jpg" alt="logo" class="object-cover h-full">
        </div>
        <div class="bg-white w-full md:w-1/2 flex flex-col items-center py-32 px-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                Bienvenido Ingresa con tu cuenta
            </h3>
            <form action="/login" method="post" class="w-full flex flex-col justify-center" novalidate>
                <div class="mb-4">
                    <input name="email" type="email" placeholder="Email" class="w-full p-3 rounded border placeholder-gray-400 focus:outline-none focus:border-indigo-900 <?php echo $model->hasError('email') ? 'border-red-500' : '' ?>" value="<?php echo $email ?>" />
                    <span class="mt-2 text-sm text-red-500">
                        <?php echo $model->getFirstError("email"); ?>
                    </span>
                </div>
                <div class="mb-4">
                    <input name="password" type="password" placeholder="Password" value="<?php echo $password ?>" class="w-full p-3 rounded border placeholder-gray-400 focus:outline-none focus:border-indigo-900 <?php echo $model->hasError('password') ? 'border-red-500' : '' ?>" />
                    <span class="mt-2 text-sm text-red-500">
                        <?php echo $model->getFirstError("password"); ?>
                    </span>
                </div>
                <button class="bg-indigo-900 font-bold text-white focus:outline-none rounded p-3">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
</div>