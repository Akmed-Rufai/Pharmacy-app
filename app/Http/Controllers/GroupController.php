<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groups;
use App\Models\Medicine;

class GroupController extends Controller
{
    public function create(Request $request){

        $group = $request->validate([
            'group' => 'required|string',
            'usage' => 'nullable|string',
            'prescription' => 'nullable|string'
        ]);

        Groups::create($group);
        return redirect()->route('pharmacy.index')->with('success', 'Group successfully created');
    }
    public function new(){

        $medicines = Medicine::all();
        
        return view('pharmacy.group_create', ['medicines'=> $medicines]);

    }
}
