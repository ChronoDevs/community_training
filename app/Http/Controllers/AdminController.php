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

    /**
     * Update user details.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user The user to be updated
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, User $user)
    {
        $params = $request->all();

        if ($user->updateUser($params)) {
            // Successfully updated
            return redirect()->route('admin.users')->with('success', 'User details updated successfully.');
        } else {
            // Handle the error case
            return redirect()->route('admin.users')->with('error', 'Failed to update user details.');
        }
    }

    /**
     * Display the user details editing form.
     *
     * @param \App\Models\User $user The user to be edited
     * @return \Illuminate\Contracts\View\View
     */
    public function editUser(User $user)
    {
        return view('admin/update_user', compact('user'));
    }

    /**
     * Export a list of users as a CSV file.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportUsers()
    {
        // Retrieve all users from the database
        $users = User::all();

        // Create a new CSV writer instance
        $csv = Writer::createFromString('');

        // Add a header row to the CSV
        $csv->insertOne([
            'Name', 'Middle Name', 'Last Name', 'Gender', 'Email', 'Username', 'Nickname', 'Date of Birth', 'Contact Number', 'Zip Code', 'Address',
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

    /**
     * Search for users based on a keyword.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Use the scope to perform the search
        $users = User::search($keyword)->get();

        return view('admin.users', compact('users'));
    }
    
    public function posts()
    {
        return view('admin.posts');
    }
}
