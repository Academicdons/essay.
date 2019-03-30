<?php

namespace App\Http\Controllers\Writer;

use App\Models\Discipline;
use App\Models\UserDiscipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDisciplineController extends Controller
{
    //
    public function getAllDisciplines()
    {
        //get the current user disciplines
        $user_disciplines=UserDiscipline::where('user_id',Auth::id())->pluck('discipline_id');

        //get the disciplines which dont contain the user disciplines
        $allDisciplines=Discipline::whereNotIn('id',$user_disciplines)->get();


        return response()->json([
            'all_disciplines'=>$allDisciplines
        ]);
    }

    public function updateDisciplines(Request $request)
    {

        //loop through the array
        foreach ($request->selected_disciplines as $discipline){

            $userDiscipline=new UserDiscipline();
            $userDiscipline->user_id=Auth::id();
            $userDiscipline->discipline_id=$discipline;
            $userDiscipline->save();

        }

        return redirect()->back();
    }

    public function deleteUserDiscipline(UserDiscipline $userDiscipline)
    {
        try{
            $userDiscipline->delete();
        }catch (\Exception $e){


        }

        return redirect()->back();
    }
}
