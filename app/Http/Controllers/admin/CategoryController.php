<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();
        if(!empty($request->get("keyword"))){
            $categories = $categories->where("name","like","%".$request->get("keyword")."%");
        }
        $categories = $categories->latest()->get();
        return view("admin.category.index",compact("categories"));
    }
    public function create(){
        return view ("admin.category.create");
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $ImageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/images', $ImageName);

        $post = Category::create([
            'name'=> $request->name,
            'slug'=> $request->slug,
            'status'=> $request->status,
            'image'=> $ImageName,
        ]);
        return redirect()->route('admin.category.index')->with('success','Category Add SuccessFully');
    }
    public function edit($id){
        $category = Category::findOrFail($id);

    return view('admin.category.update', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $category = Category::findOrFail($id);
    
        // Check if a new image file is provided
        if ($request->hasFile('image')) {
            // Delete the previous image file
            Storage::delete('public/images/' . $category->image);
    
            // Upload the new image file
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/images', $imageName);
    
            // Update the category with the new image
            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'image' => $imageName,
            ]);
        } else {
            // Update the category without changing the image
            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
        }
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete the category's image file
        if ($category->image) {
            Storage::delete('public/images/' . $category->image);
        }

        // Delete the category from the database
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }
}
