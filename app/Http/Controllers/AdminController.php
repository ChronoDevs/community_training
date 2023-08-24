<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin.home');
    }

    public function users()
    {
        $users = User::all(); // Retrieve all registered users
        return view('admin.users', compact('users'));
    }

    public function posts()
    {
        return view('admin.posts');
    }

    public function categories()
    {
        $categories = Category::paginate(9); // Retrieve categories with pagination
        return view('admin.categories', compact('categories'));
    }    

    public function createCategory(Request $request)
    {
        // Validate the input
        $request->validate([
            'category_title' => 'required|string|max:255',
            // Add more validation rules if needed
        ]);

        // Create a new category
        $category = new Category();
        $category->title = $request->input('category_title');
        // Set other attributes if needed
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->title = $request->input('title');
        // Update other fields if needed
        $category->save();
    
        // Fetch the updated category after saving changes
        $updatedCategory = Category::findOrFail($id);
    
        return redirect()->route('admin.categories')->with([
            'success' => 'Category updated successfully.',
            'updatedCategory' => $updatedCategory, // Pass the updated category to the view
        ]);
    }
    
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }

    public function tags()
    {
        return view('admin.tags');
    }

    public function searchCategories(Request $request)
    {
        $term = $request->input('term');
        $categories = Category::where('title', 'LIKE', '%' . $term . '%')->limit(10)->get();
    
        return response()->json($categories);
    }  
}
