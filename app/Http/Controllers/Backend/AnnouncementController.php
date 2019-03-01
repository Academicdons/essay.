<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('backend.announcement.index');
    }

    public function newAnnouncement()
    {
        return view('backend.announcement.new');
    }

    public function store(Request $request)
    {

    }
}
