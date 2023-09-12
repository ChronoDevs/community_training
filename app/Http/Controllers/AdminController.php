<?php

namespace App\Http\Controllers;
use App\Http\Requests\Admin\CreateCategoryRequest;
use Illuminate\Http\Request;
use League\Csv\Writer;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Support\Facades\Config;

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

    /**
     * Display a paginated list of categories in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function categories()
    {
        $page = Config::get('const.page_pagination');
        $categories = Category::paginate($page); // Retrieve categories with pagination

        return view('admin.categories', compact('categories'));
    }

    /**
     * Create a new category based on the provided request.
     *
     * @param  \App\Http\Requests\CreateCategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createCategory(CreateCategoryRequest $request)
    {
        // Get the category title from the request
        $name = $request->input('category_title');

        // Call the register method from the Category model (provided by the Register trait)
        $category = Category::register(
            ['name' => $name],
            null, // You can pass before_function if needed
            null, // You can pass after_function if needed
            function ($category) {
                // Category created successfully
                return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
            },
            function () {
                // Category creation failed
                return redirect()->route('admin.categories')->with('error', 'Category creation failed. Please try again.');
            }
        );

        // Return the result from the register method
        return $category;
    }

    /**
     * Display the form for editing a specific category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function editCategory(Category $category)
    {
        return view('admin.edit_category', compact('category'));
    }

    /**
     * Update the details of a category based on the provided request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(Request $request, Category $category)
    {
        $name = $request->input('name');

        // Call the updater method from the Category model (provided by the Updater trait)
        return $category->updater(
            ['name' => $name],
            null, // You can pass before_function if needed
            null, // You can pass after_function if needed
            function ($category) {
                // Category updated successfully
                // Fetch the updated category after saving changes
                $updatedCategory = Category::findOrFail($category->id);

                return redirect()->route('admin.categories')->with([
                    'success' => 'Category updated successfully.',
                    'updatedCategory' => $updatedCategory, // Pass the updated category to the view
                ]);
            },
            function () {
                // Category update failed
                return redirect()->route('admin.categories')->with('error', 'Category update failed. Please try again.');
            }
        );
    }

    /**
     * Delete a specific category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory(Category $category)
    {
        // Call the deleteCategory method in the Category model
        if ($category->deleteCategory()) {
            // Category deleted successfully
            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
        } else {
            // Category deletion failed
            return redirect()->route('admin.categories')->with('error', 'Category deletion failed. Please try again.');
        }
    }   
}
