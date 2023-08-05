<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', ['admins' => $admins]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->phone = $request->input('phone');
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->email_verified_at = now();
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin added successfully');
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.edit', ['admin' => $admin]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = Admin::find($id);
        $admin->name = $request->input('name');
        $admin->phone = $request->input('phone');
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin updated successfully');
    }

    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully');
    }
}
