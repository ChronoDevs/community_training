<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Config;

class CategoryController extends Controller
{
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
                return redirect()->route('admin.categories')->with('success',  __('messages.success.create'));
            },
            function () {
                // Category creation failed
                return redirect()->route('admin.categories')->with('error',  __('messages.error.create'));
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
                    'success' =>  __('messages.success.update'),
                    'updatedCategory' => $updatedCategory, // Pass the updated category to the view
                ]);
            },
            function () {
                // Category update failed
                return redirect()->route('admin.categories')->with('error',  __('messages.error.update'));
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
            return redirect()->route('admin.categories')->with('success',  __('messages.success.delete'));
        } else {
            // Category deletion failed
            return redirect()->route('admin.categories')->with('error', __('messages.error.delete'));
        }
    } 
}
