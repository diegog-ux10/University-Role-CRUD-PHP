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

    public function create(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $model = new Teacher();
        $classes = $model->getAllClasses();
        $users = $model->all();
        $data = $this->getDataTeachers($users);

        if ($request->isPost()) {
            $model->loadData($request->getBody());
            if ($model->validate() && $model->save()) {
                Application::$app->session->set("message", "Maestro Creado Exitosamente!");
                Application::$app->response->redirect("/maestros");
            }
            $this->setLayout("main");
            return $this->render("teacher-create", [
                "model" => $model,
                'teachers' => $data,
                'classes' => $classes

            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("teacher-create", [
                "model" => $model,
                'teachers' => $data,
                'classes' => $classes
            ]);
        }
    }

    public function update(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $teacherId = $request->getBody()["id"];

        $model = new Teacher();
        $users = $model->all();
        $data = $this->getDataTeachers($users);
        $classes = $model->getAllClasses();
        $teacherForEdit = $model->findOne(["id" => $teacherId]);

        if ($request->isPost()) {
            $model->loadData($request->getBody());
            if ($model->validateUpdate() && $model->update($teacherId)) {
                Application::$app->session->set("message", "Maestro Actualizado Exitosamente!");
                Application::$app->response->redirect("/maestros");
            }
            $this->setLayout("main");
            return $this->render("teacher-edit", [
                "model" => $teacherForEdit,
                'teachers' => $data,
                'classes' => $classes
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("teacher-edit", [
                "model" => $teacherForEdit,
                'teachers' => $data,
                'id' => $teacherId,
                'classes' => $classes
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
