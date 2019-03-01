<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard');
    }

    public function discipline()
    {
        return view('backend.discipline.index');
    }

    public function educationLevel()
    {
        return view('backend.education_level.index');
    }

    public function paperType()
    {
        return view('backend.paper_type.index');
    }
}
