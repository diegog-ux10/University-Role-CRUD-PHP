<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\DbModel;
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

        $user_id = $request->getBody()["id"];

        $model = new User();
        $users = $model->all();
        $userForEdit = $model->findOne(["id" => $user_id]);

        if ($request->isPost()) {
            $body = $request->getBody();
            $role = $body['id_role'] ? $body['id_role'] : null;
            $model->loadData($body);
            if ($model->validateUpdate() && $model->updateUser($user_id, $role)) {
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

    public function update(Request $request, Response $response)
    {
        $user = parent::checkAuth($response);
        $user_id = $user['id'];
        $user_model = new User();
        $user_for_edit =  $user_model->findUser($user_id);
        if ($request->isPost()) {
            $body = $request->getBody();
            $user_model->loadData($body);
            if ($user_model->validateUpdate() && $user_model->updateUser($user_id)) {
                Application::$app->session->set("message", "Usuario Actualizado Exitosamente!");
                Application::$app->response->redirect("/editar-usuario");
            }
            $this->setLayout("main");
            return $this->render("user-edit", [
                "model" => $user_for_edit,
            ]);
        }   
        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("user-edit", [
                "model" => $user_for_edit,
            ]);
        }
    }



    public function delete(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $teacher_id = $request->getBody()["id"];
        $model = new Teacher();
        if ($model->delete($teacher_id)) {
            Application::$app->session->set("message", "Maestro Eliminado Exitosamente!");
            Application::$app->response->redirect("/maestros");
        };
    }

    public function getDataTeachers($users)
    {
        $data = [];
        foreach ($users as $user) {
            if ($user["id_role"] !== 2) {
                continue;
            }
            $teacher_name = $user["firstname"] . " " . $user["lastname"];
            if ($user["id_class"]) {
                $assigned_class = Teacher::getAsignedClass($user["id_class"]);
                $assignedClassName = $assigned_class->name;
            } else {
                $assignedClassName = "Sin Asignar";
            }
            $data[] = ["id" => $user["id"], "name" => $teacher_name, "email" => $user["email"], "address" => $user["address"], "bday" => $user["bday"], "asigned_class" => $assignedClassName];
        }
        return $data;
    }
}
