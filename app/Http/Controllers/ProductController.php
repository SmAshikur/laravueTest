<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Feature; // Assuming you have a Product model

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        return response()->json(Product::with(['categories','feature'])->get(), 200);

    }

    // Create a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'features' => 'nullable|array',
        ]);

        $imagePath = $request->file('image')->store('product_images', 'public');
        $imageUrl = asset('storage/' . $imagePath);
        $product = Product::create([
            'name' => $request->name,
            'image' => $imageUrl,
            //'categories' => json_encode($request->categories),
            //'features' => json_encode($request->features),
        ]);
        $product->category()->sync($request->categories);
        if ($request->has('features')) {
            foreach ($request->features as $featureDescription) {
                // Insert each feature with the product_id and description
                Feature::create([
                    'product_id' => $product->id,
                    'description' => $featureDescription
                ]);
            }
        }

        return response()->json($product, 201);
    }

    // Show a specific product
    public function show($id)
    {
        $product = Product::with(['categories','feature'])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        $d = $request->all();
        return response()->json($d);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',  // Validating image as optional
        ]);

        $product = Product::findOrFail($id.$d);
        $product->name = $validatedData['name'];

        if ($request->hasFile('image')) {
            // Store image and get URL
            $imagePath = $request->file('image')->store('products');
            $product->image = asset('storage/' . $imagePath);
        }

        $product->save();

        return response()->json($product, 200);  // Return updated product as JSON
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
