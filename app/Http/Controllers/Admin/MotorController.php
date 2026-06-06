<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index()
    {
        $motors = \App\Models\Motor::latest()->paginate(10);
        return view('admin.motors.index', compact('motors'));
    }

    public function create()
    {
        return view('admin.motors.create');
    }

    public function store(\App\Http\Requests\StoreMotorRequest $request)
    {
        \App\Models\Motor::create($request->validated());

        return redirect()->route('admin.motors.index')->with('success', 'Motor created successfully.');
    }

    public function edit(\App\Models\Motor $motor)
    {
        return view('admin.motors.edit', compact('motor'));
    }

    public function update(\App\Http\Requests\UpdateMotorRequest $request, \App\Models\Motor $motor)
    {
        $motor->update($request->validated());

        return redirect()->route('admin.motors.index')->with('success', 'Motor updated successfully.');
    }

    public function destroy(\App\Models\Motor $motor)
    {
        if ($motor->status === 'in_use') {
            return redirect()->route('admin.motors.index')->withErrors(['error' => 'Cannot delete motor currently in use.']);
        }
        
        $motor->delete();

        return redirect()->route('admin.motors.index')->with('success', 'Motor deleted successfully.');
    }
}
