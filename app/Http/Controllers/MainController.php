<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;

class MainController extends Controller
{
    public function index()
    {
        return View('main');
    }
}
