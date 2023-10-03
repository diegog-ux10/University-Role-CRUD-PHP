<?php

use core\Application;

$user = Application::$app->session->get("user");

$notenrolledClassesForStudent = [];
$enrolledClassesForStudent = [];
foreach ($enrolledClasses as $enrolledclass) {
    if ($enrolledclass["id_student"] === $user['id']) {
        foreach ($classes as $class) {
            if ($class['id'] === $enrolledclass["id_class"]) {
                $enrolledClassesForStudent[] = ['id' => $class['id'], 'name' => $class['name'], 'grade' => $enrolledclass['grade'] ?? "Sin Calificacion"];
            } else {
                $notenrolledClassesForStudent[] = $class;
            }
        }
    }
}

?>

<?php if ($user["rol"] === "STUDENT") : ?>
    <div>
        <h1 class="mb-2">Esquema de Clases</h1>
    </div>
    <div class="flex w-full gap-4">

        <div class="bg-white rounded w-3/5">
            <div class="flex justify-between border border-gray-500 py-4 px-4">
                <h2>Tus Materias Inscritas</h2>
            </div>
            <div class="border border-gray-500 py-3 px-4">
                <table class="w-full">
                    <thead>
                        <tr>
                            <td class="px-4">#</td>
                            <td>Materia</td>
                            <td class="flex justify-center">Darse de Baja</td>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($enrolledClassesForStudent as $class) : ?>
                            <tr class="odd:bg-slate-200">
                                <td class="px-4"><?php echo $class["id"] ?></td>
                                <td><?php echo $class["name"] ?></td>
                                <td class="flex justify-center">
                                    <span class="material-symbols-outlined text-red-600">
                                        close
                                    </span>
                                </td>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded w-2/5">
            <div class="flex justify-between border border-gray-500 py-4 px-4">
                <h2>Materias para inscribir</h2>
            </div>
            <div class="border border-gray-500 py-3 px-4 w-full">
                <form action="/clases/administrar" method="post">
                    <label for="enrolled_class" class="font-bold">Selecciona la(s) Clase(s) usa la tecla ctrl</label>
                    <select name="enrolled_classes" id="" multiple class="w-full">
                        <?php foreach ($notenrolledClassesForStudent as $class) :  ?>
                            <option value="<?php echo $class['id'] ?>"><?php echo $class['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="ml-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Inscribir</button>
                </form>
            </div>
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