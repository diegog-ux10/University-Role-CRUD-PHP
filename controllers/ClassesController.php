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
        $loggedUserId = parent::getLoggedUserId();
        $model = new Classes();
        $classes = $model->all();
        $data = $this->getDataClasses($classes);
        $enrolledClasses = $model->getEnrolledClasses($loggedUserId);
        $this->setLayout("main");
        return $this->render("class-read", [
            'classes' => $data,
            'enrolledClasses' => $this->getEnrolledClassDataDisplay($classes, $enrolledClasses, $loggedUserId)
        ]);
    }

    public function getEnrolledClass(Request $request, Response $response)
    {

        parent::checkAuth($response);
        $loggedUserId = parent::getLoggedUserId();

        $model = new Classes();
        $classes = $model->all();
        $data = $this->getDataClasses($classes);
        $enrolledClasses = $model->getEnrolledClasses($loggedUserId);

        if ($request->isPost()) {
            $registeredClassesId = $_POST["enrolledClasses"];

            if ($model->registerClasses($registeredClassesId, $loggedUserId)) {
                Application::$app->session->set("message", "Clase Agregada Exitosamente!");
                Application::$app->response->redirect("/administrar-clases");
            }
        }

        $this->setLayout("main");
        return $this->render("enrolled-class-edit", [
            'classes' => $data,
            'enrolledClasses' => $this->getEnrolledClassDataDisplay($classes, $enrolledClasses, $loggedUserId),
        ]);
    }

    public function update(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $classId = $request->getBody()["id"];
        $model = new Classes();
        $classes = $model->all();
        $data = $this->getDataClasses($classes);
        $teachers = $model->getAllTeachers();
        $classForEdit = $model->findOne(["id" => $classId]);

        if ($request->isPost()) {
            $body = $request->getBody();
            $teacherId = $body["id_teacher"] ? $body["id_teacher"] : null;
            $model->loadData($body);
            if ($model->validate() && $model->updateClass($classId, $teacherId)) {
                Application::$app->session->set("message", "Clase Editada Exitosamente!");
                Application::$app->response->redirect("/clases");
            }

            $this->setLayout("main");
            return $this->render("class-edit", [
                'model' => $classForEdit,
                'classes' => $data
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("class-edit", [
                'model' => $classForEdit,
                'classes' => $data,
                'teachers' => $teachers,
                'id' => $classId
            ]);
        }
    }

    public function delete(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $classId = $request->getBody()["id"];
        $model = new Classes();
        if ($model->delete($classId)) {
            Application::$app->session->set("message", "Clase Eliminada Exitosamente!");
            Application::$app->response->redirect("/clases");
        };
    }

    public function getDataClasses($classes)
    {
        $data = [];
        foreach ($classes as $class) {

            if ($class["id_teacher"]) {
                $teacherName = Classes::getTeacherName($class["id_teacher"]);
            } else {
                $teacherName = "Sin asignar";
            }
            $enrolled_students = Classes::getCount($class["id"], 'id_class', 'enrolled_classes');
            if ($enrolled_students === 0) {
                $enrolled_students = "Sin Alumnos";
            }
            $data[] = ["id" => $class["id"], "name" => $class["name"], "teacher" => $teacherName, "enrolled_students" => $enrolled_students];
        }

        return $data;
    }

    public function getEnrolledClassDataDisplay($classes, $enrolledClasses, $userId)
    {
        $enrolledClassesForStudent = [];
        $notEnrolledClassesForStudent = [];

        if ($enrolledClasses) {
            $notEnrolledClassesForStudent = Classes::getNotRegisteredClass($userId);
        } else {
            $notEnrolledClassesForStudent = $classes;
        }

        echo '<pre>';
        var_dump($enrolledClassesForStudent);
        echo '</pre>';
        echo '<pre>';
        var_dump($notEnrolledClassesForStudent);
        echo '</pre>';
        exit;
        return [
            "enrolled_classes" => $enrolledClassesForStudent,
            "not_enrolled_classes" =>  $notEnrolledClassesForStudent
        ];
    }

    public function deleteEnrolledClass(Request $request, Response $response)
    {
        parent::checkAuth($response);
        $loggedUserId = parent::getLoggedUserId();
        $classId = $request->getBody()["id"];
        $model = new Classes();
        if ($request->isPost()) {
            $body = $request->getBody();
            $model->loadData($body);
            if ($model->deleteEnrolledClass($classId, $loggedUserId)) {
                Application::$app->session->set("message", "Clase Eliminada Exitosamente!");
                Application::$app->response->redirect("/administrar-clases");
            }
        }
    }
}
