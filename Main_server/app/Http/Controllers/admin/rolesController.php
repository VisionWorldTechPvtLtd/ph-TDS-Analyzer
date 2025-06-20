<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\roles;

class rolesController extends Controller
{
     public function index(){
        return view('admin.roles');
     }

     public function store(Request $request)
     {
         $request->validate([
             'roles' => 'required|string',
         ]);
         roles::create([
             'roles' => $request->input('roles'),
         ]);
         return redirect()->back()->with('success', 'roles created successfully.');
     }
}
