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
        return true;
    }

    public function getLoggedUserId()
    {
        $user = Application::$app->session->get("user");
        return $user['id'];
    }
}
