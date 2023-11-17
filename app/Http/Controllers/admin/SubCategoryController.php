<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request){
        $subcategories = SubCategory::latest();
        if(!empty($request->get("keyword"))){
            $subcategories = $subcategories->where("name","like","%".$request->get("keyword")."%");
        }
        $subcategories = $subcategories->paginate(6);
        return view("admin.subcategory.index",compact("subcategories"));
    }
    public function create(){
        $categories = Category::orderBy('name','ASC')->get();
        return view('admin.subcategory.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
            'slug' => 'required|string|max:255',
        ]);
    
        $subcategory = SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category,
            'status' => $request->status,
            'slug' => $request->slug,
        ]);
    
        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory created successfully');
    }
    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('admin.subcategory.update', compact('subcategory', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
            'slug' => 'required|string|max:255',
        ]);

        $subcategory = Subcategory::findOrFail($id);

        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'status' => $request->status,
            'slug' => $request->slug,
        ]);

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory updated successfully');
    }
    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        
        // You may want to add additional logic here, such as checking if the user has the necessary permissions to delete.

        $subcategory->delete();

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory deleted successfully');
    }
}
