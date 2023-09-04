<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use League\Csv\Writer;

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
    $user->middle_name = $request->input('middle_name');
    $user->last_name = $request->input('last_name');
    $user->gender = $request->input('gender');
    $user->email = $request->input('email');
    $user->user_name = $request->input('user_name');
    $user->nickname = $request->input('nickname');
    $user->date_of_birth = $request->input('date_of_birth');
    $user->contact_number = $request->input('contact_number');
    $user->zip_code = $request->input('zip_code');
    $user->address = $request->input('address');

    $user->save();

    return redirect()->back()->with('success', 'User details updated successfully.');
    }

    public function exportUsers()
    {
    $users = User::all();

    // Create a new CSV writer instance
    $csv = Writer::createFromString('');

    // Add a header row to the CSV
    $csv->insertOne([
        'Name', 'Middle Name', 'Last Name',  'Gender', 'Email', 'Username', 'Nickname', 'Date of Birth', 'Contact Number', 'Zip Code', 'Address',
    ]);

    // Add data rows to the CSV
    foreach ($users as $user) {
        $csv->insertOne([
            $user->name,
            $user->middle_name,
            $user->last_name,
            $user->gender,
            $user->email,
            $user->user_name,
            $user->nickname,
            $user->date_of_birth,
            $user->contact_number,
            $user->zip_code,
            $user->address,
        ]);
    }

    // Define the CSV file name
    $filename = 'users.csv';

    // Set appropriate headers for download
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename=\"$filename\"");

    // Output the CSV content
    echo $csv;
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
    
        // Perform the search based on the keyword (you can customize the search criteria)
        $users = User::where('id', 'like', "%$keyword%")
                     ->orWhere('name', 'like', "%$keyword%")
                     ->get();
    
        return view('admin.users', compact('users'));
    }    
}
