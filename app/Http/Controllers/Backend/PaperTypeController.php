<?php

namespace App\Http\Controllers\Backend;

use App\Models\PaperType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaperTypeController extends Controller
{
    public function add(Request $request)
    {
        if ($request->has('id') && $request->id != null){
            $discipline = PaperType::find($request->id);
        }else{
            $discipline = new PaperType();
        }

        $discipline->name = $request->name;
        $discipline->save();

        return back();
    }

    public function deletePaperType(PaperType $paperType)
    {
        try {
            $paperType->delete();
        } catch (\Exception $e) {
        }

        return back();
    }
}
