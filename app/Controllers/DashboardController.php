<?php

namespace App\Controllers;

use App\Models\Resume;
use App\Support\Auth;
use App\Support\Csrf;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->ensureAuthenticated();
        $user = Auth::user();
        $resumes = Resume::allByUser($user['id']);
        $this->render('dashboard/index', [
            'title' => 'Meu painel',
            'user' => $user,
            'resumes' => $resumes,
            'csrfToken' => Csrf::token(),
        ]);
    }

    private function ensureAuthenticated(): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }
    }
}
