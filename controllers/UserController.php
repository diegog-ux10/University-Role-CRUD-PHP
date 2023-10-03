<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Teacher;
use models\User;

class UserController extends Controller
{

    public function manageUsers(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $model = new User();
        $users = $model->all();

        $this->setLayout("main");
        return $this->render("user-manage", [
            'users' => $users
        ]);
    }

    public function updateRoles(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $userId = $request->getBody()["id"];

        $model = new User();
        $users = $model->all();
        $userForEdit = $model->findOne(["id" => $userId]);

        if ($request->isPost()) {
            $body = $request->getBody();
            $role = $body['id_role'] ? $body['id_role'] : null;
            $model->loadData($body);
            if ($model->validateUpdate() && $model->updateUser($userId, $role)) {
                Application::$app->session->set("message", "Permisos Actualizado Exitosamente!");
                Application::$app->response->redirect("/permisos");
            }
            $this->setLayout("main");
            return $this->render("user-admin", [
                "model" => $userForEdit,
                'users' => $users,
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("user-admin", [
                "model" => $userForEdit,
                'users' => $users,
            ]);
        }
    }

    public function delete(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $teacherId = $request->getBody()["id"];
        $model = new Teacher();
        if ($model->delete($teacherId)) {
            Application::$app->session->set("message", "Maestro Eliminado Exitosamente!");
            Application::$app->response->redirect("/maestros");
        };
    }

    public function getDataTeachers($users)
    {
        $data = [];
        foreach ($users as $user) {
            if($user["id_role"] !== 2) {
                continue;
            }
            $teacherName = $user["firstname"] . " " . $user["lastname"];
            if ($user["id_class"]) {
                $assigned_class = Teacher::getAsignedClass($user["id_class"]);
                $assignedClassName = $assigned_class->name;
            } else {
                $assignedClassName = "Sin Asignar";
            }
            $data[] = ["id" => $user["id"], "name" => $teacherName, "email" => $user["email"], "address" => $user["address"], "bday" => $user["bday"], "asigned_class" => $assignedClassName];
        }
        return $data;
    }
}
