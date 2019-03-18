<?php

namespace App\Http\Controllers\Backend;

use App\Models\Discipline;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

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
        $discipline->group_id=$request->group;
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

    public function editDiscipline(Discipline $discipline)
    {
        return Response::json([
            'discipline' => $discipline
        ]);
    }

    public function groupsView()
    {
        return view('backend.discipline.group');
    }

    public function saveGrouping(Request $request)
    {
        if ($request->has('id') && $request->id!=null){
            $group=Group::find($request->id);

        }else{
            $group=new Group();
        }

        $group->name=$request->name;
        $group->base_price=$request->base_price;
        $group->writer_price=$request->writer_price;
        $group->save();

        return redirect()->back();


    }
}
