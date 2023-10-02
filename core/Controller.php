<?php

namespace core;

class Controller
{
    public string $layout = "main";

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function checkAuth(Response $response)
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
        return true;
    }
}
