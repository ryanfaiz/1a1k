<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $materiCount = Course::count();
        $userCount = User::count();

        return view('index', [
            'materiCount' => $materiCount,
            'userCount'   => $userCount
        ]);
    }
}
