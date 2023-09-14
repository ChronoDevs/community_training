<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateTagRequest;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Config;

class TagController extends Controller
{
       /**
     * Display a paginated list of tags in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function tags()
    {
        $page = Config::get('const.page_pagination');
        $tags = Tag::paginate($page); // Retrieve tags with pagination

        return view('admin.tags', compact('tags'));
    }

    /**
     * Create a new tag based on the provided request.
     *
     * @param  \App\Http\Requests\CreateTagRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTag(CreateTagRequest $request)
    {
        // Get the Tag title from the request
        $name = $request->input('tag_title');

        // Call the register method from the Tag model (provided by the Register trait)
        $tag = Tag::register(
            ['name' => $name],
            null, // You can pass before_function if needed
            null, // You can pass after_function if needed
            function () {
                // Tag created successfully
                return redirect()->route('admin.tags')->with('success', __('messages.success.create'));
            },
            function () {
                // Tag creation failed
                return redirect()->route('admin.tags')->with('error', __('messages.error.create'));
            }
        );

        // Return the result from the register method
        return $tag;
    }

        /**
     * Display the form for editing a specific tag.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\View\View
     */
    public function editTag(Tag $tag)
    {
        return view('admin.edit_tag', compact('tag'));
    }

        /**
     * Update the details of a tag based on the provided request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTag(Request $request, Tag $tag)
    {
        $name = $request->input('name');

        // Call the updater method from the Tag model (provided by the Updater trait)
        return $tag->updater(
            ['name' => $name],
            null, // You can pass before_function if needed
            null, // You can pass after_function if needed
            function ($tag) {
                // Tag updated successfully
                // Fetch the updated tag after saving changes
                $updatedTag = Tag::findOrFail($tag->id);

                return redirect()->route('admin.tags')->with([
                    'success' => __('messages.success.update'),
                    'updatedTag' => $updatedTag, // Pass the updated tag to the view
                ]);
            },
            function () {
                // tag update failed
                return redirect()->route('admin.tags')->with('error', __('messages.error.update'));
            }
        );
    }

    /**
     * Delete a specific tag.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTag(Tag $tag)
    {
        // Call the deleteTag method on the $tag instance
        if ($tag->deleter()) {
            // Tag deleted successfully
            return redirect()->route('admin.tags')->with('success', __('messages.success.delete'));
        } else {
            // Tag deletion failed
            return redirect()->route('admin.tags')->with('error',  __('messages.error.delete'));
        }
    }
}
