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
    // TODO: Arreglar Login Controller
    public function login(Request $request, Response $response)
    {
        $loginForm = new Login();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            // $loginForm->validate() && $loginForm->login()
            if (true) {
                Application::$app->session->set("user", ["name" => "Diego", "rol" => "ADMIN"]);
                $response->redirect("/");
            }
        }
        $this->setLayout("auth");
        return $this->render("login", [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();

        if ($request->isPost()) {

            $user->loadData($request->getBody());
            if ($user->validate() && $user->save()) {
                $userData = User::findOne(["email" => $user->email]);
                session_start();
                $_SESSION["user"] = $userData->id;
                Application::$app->response->redirect("/");
            }
            $this->setLayout("auth");
            return $this->render("register", [
                "model" => $user
            ]);
        }
        $this->setLayout("auth");
        return $this->render("register", [
            "model" => $user
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect("/");
    }
}
