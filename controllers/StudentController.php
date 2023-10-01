<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Student;
use models\StudentEdit;
use models\User;

class StudentController extends Controller
{
    public function getStudents(Request $request, Response $response)
    {
        $user = Application::$app->session->get("user");
        if (!$user) {
            $response->redirect("/login");
        };
        if ($user["rol"] === "STUDENT") {
            $this->setLayout("main");
            return $this->render("unauthorized", [
                'message' => "No tiene los permisos necesarios para ver esta opción."
            ]);
        }
        $model = new Student();
        $students = $model->all();
        $this->setLayout("main");
        return $this->render("students", [
            'students' => $students
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $user = Application::$app->session->get("user");
        if (!$user) {
            $response->redirect("/login");
        };
        if ($user["rol"] === "STUDENT") {
            $this->setLayout("main");
            return $this->render("unauthorized", [
                'message' => "No tiene los permisos necesarios para ver esta opción."
            ]);
        }
        $newStudent = new Student();
        $students = $newStudent->all();
        if ($request->isPost()) {
            $newStudent->loadData($request->getBody());
            if ($newStudent->validate() && $newStudent->save()) {
                Application::$app->session->set("message", "Usuario Creado Exitosamente!");
                Application::$app->response->redirect("/alumnos");
            }
            $this->setLayout("main");
            return $this->render("create-student", [
                "model" => $newStudent,
                'students' => $students

            ]);
        }
        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("create-student", [
                "model" => $newStudent,
                'students' => $students
            ]);
        }
    }

    public function update(Request $request, Response $response)
    {
        $studentId = $request->getBody()["id"];
        $user = Application::$app->session->get("user");
        if (!$user) {
            $response->redirect("/login");
        };
        if ($user["rol"] === "STUDENT") {
            $this->setLayout("main");
            return $this->render("unauthorized", [
                'message' => "No tiene los permisos necesarios para ver esta opción."
            ]);
        }

        $model = new StudentEdit();
        $students = $model->all();
        $studentForEdit = $model->findOne(["id" => $studentId]);

        if ($request->isPost()) {
            $model->loadData($request->getBody());
            echo $studentId;
            if ($model->validate() && $model->update($studentId)) {
                Application::$app->session->set("message", "Estudiante Actualizado Exitosamente!");
                Application::$app->response->redirect("/alumnos");
            }
            $this->setLayout("main");
            return $this->render("edit-student", [
                "model" => $studentForEdit,
                'students' => $students
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("edit-student", [
                "model" => $studentForEdit,
                'students' => $students,
                'id' => $studentId
            ]);
        }
    }
}
