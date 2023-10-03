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
        parent::checkAuth($response);
        $model = new Student();
        $users = $model->all();
        $data = $this->getAllStudents($users);

        $this->setLayout("main");
        return $this->render("student-read", [
            'students' => $data,
            'model' => $model
        ]);
    }

    public function create(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $model = new Student();
        $users = $model->all();
        $data = $this->getAllStudents($users);

        if ($request->isPost()) {
            $model->loadData($request->getBody());
            if ($model->validate() && $model->save()) {
                Application::$app->session->set("message", "Usuario Creado Exitosamente!");
                Application::$app->response->redirect("/alumnos");
            }
            $this->setLayout("main");
            return $this->render("student-create", [
                "model" => $model,
                'students' => $data

            ]);
        }
        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("student-create", [
                "model" => $model,
                'students' => $data
            ]);
        }
    }

    public function update(Request $request, Response $response)
    {
        $studentId = $request->getBody()["id"];
        parent::checkAuth($response);

        $model = new Student();
        $users = $model->all();
        $data = $this->getAllStudents($users);
        $studentForEdit = $model->findOne(["id" => $studentId]);

        if ($request->isPost()) {
            $model->loadData($request->getBody());
            if ($model->validateUpdate() && $model->update($studentId)) {
                Application::$app->session->set("message", "Estudiante Actualizado Exitosamente!");
                Application::$app->response->redirect("/alumnos");
            }
            $this->setLayout("main");
            return $this->render("student-edit", [
                "model" => $studentForEdit,
                'students' => $data
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("student-edit", [
                "model" => $studentForEdit,
                'students' => $data,
                'id' => $studentId
            ]);
        }
    }

    public function delete(Request $request, Response $response)
    {
        $studentId = $request->getBody()["id"];

        parent::checkAuth($response);

        $model = new Student();
        if ($model->delete($studentId)) {
            Application::$app->session->set("message", "Estudiante Eliminado Exitosamente!");
            Application::$app->response->redirect("/alumnos");
        };
    }

    public function getAllStudents($users)
    {
        $data = [];
        foreach ($users as $user) {
            if ($user["id_role"] !== 3) {
                continue;
            }
            $enrolledClasses = Student::getEnrolledClassesByStudentId($user["id"]);
            $user["enrolled_classes"] = $enrolledClasses;
            $data[] = $user;
        }
        return $data;
    }
}
