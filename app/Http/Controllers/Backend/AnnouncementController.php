<?php

namespace App\Http\Controllers\Backend;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

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
        if ($request->has('id') && $request->id != null){
            $announce = Announcement::find($request->id);
        }else{
            $announce = new Announcement();
        }

        $announce->title = $request->title;
        $announce->news_article = $request->news_article;
        $announce->save();

        return Redirect::route('admin.announce.index');
    }

    public function markAsInActive(Announcement $id)
    {
        $id->status=false;
        $id->save();

        return \redirect()->back();
    }
}
