<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Student;

class StudentController extends Controller
{
    public function getStudents(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $logged_user_Id = parent::getLoggedUserId();
        $model = new Student();
        $users = $model->all();
        $data = $model->getAllStudents($users);
        $assigned_students = $model->getAllAssignedStudents($logged_user_Id);
        $this->setLayout("main");
        return $this->render("student-read", [
            'students' => $data,
            'model' => $model,
            'assignedStudents' => $assigned_students
        ]);
    }

    public function create(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $model = new Student();
        $users = $model->all();
        $data = $model->getAllStudents($users);
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
        $student_id = $request->getBody()["id"];
        parent::checkAuth($response);

        $model = new Student();
        $users = $model->all();
        $data = $model->getAllStudents($users);
        $student_for_edit = $model->findOne(["id" => $student_id]);

        if ($request->isPost()) {
            $model->loadData($request->getBody());
            if ($model->validateUpdate() && $model->update($student_id)) {
                Application::$app->session->set("message", "Estudiante Actualizado Exitosamente!");
                Application::$app->response->redirect("/alumnos");
            }
            $this->setLayout("main");
            return $this->render("student-edit", [
                "model" => $student_for_edit,
                'students' => $data
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("student-edit", [
                "model" => $student_for_edit,
                'students' => $data,
                'id' => $student_id
            ]);
        }
    }

    public function delete(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $student_id = $request->getBody()["id"];
        $model = new Student();
        if ($model->delete($student_id)) {
            Application::$app->session->set("message", "Estudiante Eliminado Exitosamente!");
            Application::$app->response->redirect("/alumnos");
        };
    }
}
