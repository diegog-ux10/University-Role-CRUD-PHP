<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Teacher;


class TeacherController extends Controller
{

    public function getTeachers(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $model = new Teacher();
        $users = $model->all();
        $data = $this->getDataTeachers($users);

        $this->setLayout("main");
        return $this->render("teacher-read", [
            'teachers' => $data
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
            $body = $request->getBody();
            $classId = $body['id_class'] ? $body['id_class'] : null;
            $model->loadData($body);
            if ($model->validate() && $model->saveTeacher($classId)) {
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
            $body = $request->getBody();
            $classId = $body['id_class'] ? $body['id_class'] : null;
            $model->loadData($body);
            if ($model->validateUpdate() && $model->updateTeacher($teacherId, $classId)) {
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
            $assigned_class = Teacher::getAsignedClass($teacherId);
            $this->setLayout("main");
            return $this->render("teacher-edit", [
                "model" => $teacherForEdit,
                'teachers' => $data,
                'id' => $teacherId,
                'classes' => $classes,
                'assignedClass' => $assigned_class->name ? $assigned_class->name : null,
                'assignedClassId' => $assigned_class->id ? $assigned_class->id : null,
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
            if ($user["id_role"] !== 2) {
                continue;
            }
            $teacherName = $user["firstname"] . " " . $user["lastname"];
            $assigned_class = Teacher::getAsignedClass($user["id"]);
            if ($assigned_class) {
                $assignedClassName = $assigned_class->name;
            } else {
                $assignedClassName = "Sin Asignar";
            }
            $data[] = ["id" => $user["id"], "name" => $teacherName, "email" => $user["email"], "address" => $user["address"], "bday" => $user["bday"], "assigned_class" => $assignedClassName];
        }
        return $data;
    }
}
