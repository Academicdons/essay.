<?php

namespace App\Http\Controllers\Backend;

use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisciplineController extends Controller
{
    public function add(Request $request)
    {
        if ($request->has('id') && $request->id != null){
            $discipline = Discipline::find($request->id);
        }else{
            $discipline = new Discipline();
        }

        $discipline->name = $request->name;
        $discipline->save();

        return back();
    }

    public function deleteDiscipline(Discipline $discipline)
    {
        try {
            $discipline->delete();
        } catch (\Exception $e) {
        }

        return back();
    }
}
