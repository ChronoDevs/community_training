<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use League\Csv\Writer;
use App\Models\User;
use App\Models\Listing;

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
    
    /**
     * Retrieve and display a list of listings with associated users and tags.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function posts()
    {
        // Fetch listings with their associated users and tags
        $listings = Listing::with('user', 'tags')->get();

        return view('admin.posts', ['listings' => $listings]);
    }

    /**
     * Display the inspection view for a specific listing.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Contracts\View\View
     */
    public function inspectListing(Listing $listing)
    {
        return view('admin.inspect_listing', ['listing' => $listing]);
    }

    /**
     * Update the status of a listing based on the provided status and action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateListingStatus(Request $request, Listing $listing)
    {
        $status = $request->input('status');
        $action = $request->input('action');

        // Call the custom method on the Listing instance
        $message = $listing->updateListingStatus($status, $action);

        if ($message === false) {
            return redirect()->back()->with('error', 'Invalid status provided.');
        }

        // Redirect back with the success message
        return redirect()->back()->with('success', $message);
    }

    public function filterListings(Request $request)
    {
        $status = $request->input('status');
        
        // Fetch filtered listings based on the selected status
        $listings = Listing::where('status', $status)->get();
        
        return response()->json(['listings' => $listings]);
    }
}
