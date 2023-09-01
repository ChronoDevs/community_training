<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin.home');
    }

    /**
     * Show all registered users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::all(); // Retrieve all registered users
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
    $user = User::findOrFail($id);
    // Update user details based on the request
    $user->name = $request->input('name');
    // Update other fields as needed
    $user->save();

    return redirect()->back()->with('success', 'User details updated successfully.');
    }
}
