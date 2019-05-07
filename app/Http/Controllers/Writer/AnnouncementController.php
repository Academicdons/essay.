<?php

namespace App\Http\Controllers\Writer;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    //
    public function getAnnouncementsJson()
    {
        return response()->json([
            'announcements'=>Announcement::where('status',true)->get()
        ]);
    }

    public function toggleAnnouncement()
    {
        session()->forget('markedRead');

        //setup the session with value
        session()->put('markedRead','yes');

        return redirect()->back();
    }
}
