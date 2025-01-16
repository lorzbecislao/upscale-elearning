<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;


class LoginController extends Controller
{
    public function showLoginForm(): Response
    {
        return Inertia::render('Admin/Login', [
        ]);
    }
}
