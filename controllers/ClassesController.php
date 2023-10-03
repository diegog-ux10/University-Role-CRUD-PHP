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

        $model = new Classes();
        $classes = $model->all();
        $data = $this->getDataClasses($classes);
        $enrolledClasses = $model->getEnrolledClasses();
        $this->setLayout("main");
        return $this->render("class-read", [
            'classes' => $data,
            'enrolledClasses' => $enrolledClasses
        ]);
    }

    public function getEnrolledClass(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $model = new Classes();
        $classes = $model->all();
        $data = $this->getDataClasses($classes);
        $enrolledClasses = $model->getEnrolledClasses();

        $this->setLayout("main");
        return $this->render("enrolled-class-edit", [
            'classes' => $data,
            'enrolledClasses' => $enrolledClasses
        ]);
    }

    public function create(Request $request, Response $response)
    {
        parent::checkAuth($response);

        $model = new Classes();
        $classes = $model->all();
        $data = $this->getDataClasses($classes);
        $teachers = $model->getAllTeachers();

        if ($request->isPost()) {
            $body = $request->getBody();
            $teacherId = $body["id_teacher"] ? $body["id_teacher"] : null;
            $model->loadData($body);
            if ($model->validate() && $model->saveClass($teacherId)) {
                Application::$app->session->set("message", "Clase Creada Exitosamente!");
                Application::$app->response->redirect("/clases");
            }

            $this->setLayout("main");
            return $this->render("class-create", [
                'model' => $model,
                'classes' => $data
            ]);
        }

        if ($request->isGet()) {
            $this->setLayout("main");
            return $this->render("class-create", [
                'model' => $model,
                'classes' => $data,
                'teachers' => $teachers
            ]);
        }
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
            if ($model->validate() && $model->update($classId, $teacherId)) {
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
}
