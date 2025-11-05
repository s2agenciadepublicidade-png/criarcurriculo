<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $this->render('landing/index', [
            'title' => 'Construa currículos imbatíveis com apoio de recrutadores',
        ]);
    }
}
