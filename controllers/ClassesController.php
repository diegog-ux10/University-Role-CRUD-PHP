<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Classes;

class ClassesController extends Controller
{
    public function getClasses(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $logged_user_Id = parent::getLoggedUserId();
        $model = new Classes();
        $classes = $model->all();
        $data = $model->getDataClasses($classes);
        $enrolled_classes = $model->getEnrolledClasses($logged_user_Id);
        $this->setLayout("main");
        return $this->render("class-read", [
            'classes' => $data,
            'enrolled_classes' => $this->getEnrolledClassDataDisplay($classes, $enrolled_classes, $logged_user_Id)
        ]);
    }

    public function getEnrolledClass(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $logged_user_Id = parent::getLoggedUserId();
        $model = new Classes();
        $classes = $model->all();
        $data = $model->getDataClasses($classes);
        $enrolled_classes = $model->getEnrolledClasses($logged_user_Id);
        if ($request->isPost()) {
            $registered_classes_Id = $_POST["enrolled_classes"];

            if ($model->registerClasses($registered_classes_Id, $logged_user_Id)) {
                Application::$app->session->set("message", "Clase Agregada Exitosamente!");
                Application::$app->response->redirect("/administrar-clases");
            }
        }
        $this->setLayout("main");
        return $this->render("enrolled-class-edit", [
            'classes' => $data,
            'enrolled_classes' => $this->getEnrolledClassDataDisplay($classes, $enrolled_classes, $logged_user_Id),
        ]);
    }

    public function update(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $class_id = $request->getBody()["id"];
        $model = new Classes();
        $classes = $model->all();
        $data = $model->getDataClasses($classes);
        $teachers = $model->getAllTeachers();
        $class_for_edit = $model->findOne(["id" => $class_id]);
        if ($request->isPost()) {
            $body = $request->getBody();
            $teacher_id = $body["id_teacher"] ? $body["id_teacher"] : null;
            $model->loadData($body);
            if ($model->validate() && $model->updateClass($class_id, $teacher_id)) {
                Application::$app->session->set("message", "Clase Editada Exitosamente!");
                Application::$app->response->redirect("/clases");
            }
            $this->setLayout("main");
            return $this->render("class-edit", [
                'model' => $class_for_edit,
                'classes' => $data
            ]);
        }
        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("class-edit", [
                'model' => $class_for_edit,
                'classes' => $data,
                'teachers' => $teachers,
                'id' => $class_id
            ]);
        }
    }

    public function delete(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $class_id = $request->getBody()["id"];
        $model = new Classes();
        if ($model->delete($class_id)) {
            Application::$app->session->set("message", "Clase Eliminada Exitosamente!");
            Application::$app->response->redirect("/clases");
        };
    }

    public function getEnrolledClassDataDisplay($classes, $enrolled_classes, $user_id)
    {
        $enrolled_classes_for_student = [];
        $not_enrolled_classes_for_student = [];
        if ($enrolled_classes) {
            foreach ($enrolled_classes as $enrolled_class) {
                if ($enrolled_class["id_student"] === $user_id) {
                    foreach ($classes as $class) {
                        if ($class['id'] === $enrolled_class["id_class"]) {
                            $enrolled_classes_for_student[] = ['id' => $class['id'], 'name' => $class['name'], 'grade' => $enrolled_class['grade'] ?? "Sin Calificacion"];
                        } else {
                            $not_enrolled_classes_for_student[] = $class;
                        }
                    }
                }
            }
        } else {
            $not_enrolled_classes_for_student = $classes;
        }
        return [
            "enrolled_classes" => $enrolled_classes_for_student,
            "not_enrolled_classes" =>  $not_enrolled_classes_for_student
        ];
    }

    public function deleteEnrolledClass(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $logged_user_Id = parent::getLoggedUserId();
        $class_id = $request->getBody()["id"];
        $model = new Classes();
        if ($request->isPost()) {
            $body = $request->getBody();
            $model->loadData($body);
            if ($model->deleteEnrolledClass($class_id, $logged_user_Id)) {
                Application::$app->session->set("message", "Clase Eliminada Exitosamente!");
                Application::$app->response->redirect("/administrar-clases");
            }
        }
    }
}
