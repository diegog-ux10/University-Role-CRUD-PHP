<?php


namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Login;
use models\User;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $loginForm = new Login();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect("/");
            }
        }
        $this->setLayout("auth");
        return $this->render("login", [
            'model' => $loginForm
        ]);
    }
    
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect("/");
    }
}
