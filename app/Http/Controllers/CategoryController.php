<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Assuming you have a Category model

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        return response()->json(Category::all(), 200);
    }

    // Create a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    // Show a specific category
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json($category, 200);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $products = $category->products;

        // Delete all products associated with this category
        foreach ($products as $product) {
            $product->delete();
        }
        $category->delete();


        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
