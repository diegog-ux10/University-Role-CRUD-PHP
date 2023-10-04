<?php

namespace controllers;

use core\Controller;
use core\Request;
use core\Response;

class SiteController extends Controller
{
    public function getDashboard(Request $request, Response $response)
    {
        $user = parent::checkAuth($response);
        
        $this->setLayout("main");
        return $this->render("dashboard", [
            'user' => $user
        ]);
    }

    public function unauthorized($response)
    {
        $this->setLayout("main");
        return $this->render("unauthorized", [
            'message' => "No estas autorizado para ver esta pagina"
        ]);
    }
}
