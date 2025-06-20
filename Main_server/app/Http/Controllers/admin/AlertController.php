<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\alert;

class AlertController extends Controller
{
    protected $allAlert;

    public function __construct()
    {
        $this->allAlert = alert::all();
    }

    public function index()
    {
        return view('admin.alert.index', ['alert' => $this->allAlert]);
    }

    public function create()
    {
        return view('admin.alert.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alert' => 'required|string|max:500',
            'disable' => 'required|in:0,1',
        ]);

        alert::create([
            'alert' => $request->input('alert'),
            'disable' => $request->input('disable'),
        ]);

        return redirect()->route('alert.index')->with('success', 'Alert created successfully.');
    }

    public function edit($id)
    {
        $alert = alert::findOrFail($id);
        return view('admin.alert.edit', ['alert' => $alert]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'alert' => 'required|string|max:500',
            'disable' => 'required|in:0,1',
        ]);

        $alert = alert::findOrFail($id);
        $alert->alert = $validatedData['alert'];
        $alert->disable = $validatedData['disable'];
        $alert->save();

        return redirect()->route('alert.index')->with('success', 'Alert updated successfully!');
    }

    public function destroy($id)
    {
        $alert =alert::findOrFail($id);
        $alert->delete();

        return redirect()->route('alert.index')->with('success', 'Alert deleted successfully.');
    }
}
