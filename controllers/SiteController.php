<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;

class SiteController extends Controller
{
    public function getDashboard(Request $request, Response $response)
    {   
        $user = Application::$app->session->get("user");
        if (!$user) {
            $response->redirect("/login");
        };
        $this->setLayout("main");
        return $this->render("dashboard", [
            'user' => $user
        ]);
    }
}
