<?php


namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use models\Login;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $login_form = new Login();
        if ($request->isPost()) {
            $login_form->loadData($request->getBody());
            if ($login_form->validate() && $login_form->login()) {
                $response->redirect("/");
            }
        }
        $this->setLayout("auth");
        return $this->render("login", [
            'model' => $login_form
        ]);
    }
    
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect("/");
    }
}
