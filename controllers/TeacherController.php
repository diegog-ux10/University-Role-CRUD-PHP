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
        $data = $model->getDataTeachers($users);
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
        $data = $model->getDataTeachers($users);
        if ($request->isPost()) {
            $body = $request->getBody();
            $class_id = $body['id_class'] ? $body['id_class'] : null;
            $model->loadData($body);
            if ($model->validate() && $model->saveTeacher($class_id)) {
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
        $teacher_id = $request->getBody()["id"];
        $model = new Teacher();
        $users = $model->all();
        $data = $model->getDataTeachers($users);
        $classes = $model->getAllClasses();
        $teacher_for_edit = $model->findOne(["id" => $teacher_id]);
        if ($request->isPost()) {
            $body = $request->getBody();
            $class_id = $body['id_class'] ? $body['id_class'] : null;
            $model->loadData($body);
            if ($model->validateUpdate() && $model->updateTeacher($teacher_id, $class_id)) {
                Application::$app->session->set("message", "Maestro Actualizado Exitosamente!");
                Application::$app->response->redirect("/maestros");
            }
            $this->setLayout("main");
            return $this->render("teacher-edit", [
                "model" => $teacher_for_edit,
                'teachers' => $data,
                'classes' => $classes
            ]);
        }

        if ($request->isGet()) {
            $assigned_class = Teacher::getAsignedClass($teacher_id);
            $this->setLayout("main");
            return $this->render("teacher-edit", [
                "model" => $teacher_for_edit,
                'teachers' => $data,
                'id' => $teacher_id,
                'classes' => $classes,
                'assignedClass' => $assigned_class->name ? $assigned_class->name : null,
                'assignedClassId' => $assigned_class->id ? $assigned_class->id : null,
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
}
