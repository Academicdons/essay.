<?php

namespace App\Http\Controllers\Backend;

use App\Models\EducationLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EdLevelController extends Controller
{
    public function add(Request $request)
    {
        if ($request->has('id') && $request->id != null){
            $discipline = EducationLevel::find($request->id);
        }else{
            $discipline = new EducationLevel();
        }

        $discipline->name = $request->name;
        $discipline->save();

        return back();
    }

    public function deleteEdLevel(EducationLevel $educationLevel)
    {
        try {
            $educationLevel->delete();
        } catch (\Exception $e) {
        }

        return back();
    }
}
