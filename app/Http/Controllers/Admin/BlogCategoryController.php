<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->paginate(10);
        return view('admin.blog_category.list', $data);
    }

    public function create()
    {
        return view('admin.blog_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:blog_categories,name',
            'status' => 'required',
        ]);
        try {
            $response = BlogCategory::create([
                'name' => $request->name,
                'status' => $request->status,
                'slug' => Str::slug($request->name)
            ]);
            throw_if(!$response, 'Something went wrong while storing blog category data. Please try again later.');
            return back()->with('success', 'Blog category save successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            $data['blogCategory'] = BlogCategory::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog category data found.');
            });
            return view('admin.blog_category.edit', $data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', Rule::unique('blog_categories')->ignore($id),],
        ]);
        try {
            $blogCategory = BlogCategory::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog category data found.');
            });

            $response = $blogCategory->update([
                'name' => $request->name,
                'status' => $request->status,
                'slug' => Str::slug($request->name)
            ]);
            throw_if(!$response, 'Something went wrong while storing blog category data. Please try again later.');
            return back()->with('success', 'Blog category save successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blogCategory = BlogCategory::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog category data found.');
            });

            $blog = Blog::where('blog_category_id', $id)->get();

            if ($blog){
                return back()->with('error', 'This Category is not empty.');
            }

            $blogCategory->delete();

            return redirect()->back()->with('success', 'Blog category deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function status($id){
        try {
            $blogCategory = BlogCategory::select('id', 'status')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Blog category not found.');
                });

            $blogCategory->status = ($blogCategory->status == 1) ? 0 : 1;
            $blogCategory->save();

            return back()->with('success','Blog Category Status Changed Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
}