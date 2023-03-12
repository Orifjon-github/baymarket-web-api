<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\SocialResource;
use App\Models\Product;
use App\Models\Settings\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $products = Product::all();
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Products retrieved successfully.',
                'data' => ProductResource::collection($products)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $product = Social::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Product retrieved successfully.',
                'data' => SocialResource::make($product)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request) // : \Illuminate\Http\JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'required|string',
            'time' => 'nullable|integer',
            'size' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 2,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $file = $request->file('image');
            $filename = uniqid('product_') . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('products', $file, $filename);
            $input = json_decode($request->input('size'), true);

            $size = array_map(function ($item) {
                return [
                    "name" => $item["name"],
                    "age" => $item["age"],
                ];
            }, $input);

            $product = new Product([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'image' => '/storage/public/' . $path,
                'description' => $request->description,
                'time' => $request->time ?? null,
                'size' => serialize($size),
            ]);
            $product->save();
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Product saved successfully.',
                'data' => ProductResource::make($product)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 3,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Get the social by ID
            $social = Social::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'string',
                'url' => 'string|nullable',
                'icon' => 'file|image|mimes:png,jpg,jpeg,svg|max:2048',
            ]);

            // Update the social attributes
            if ($request->input())
                $social->name = $validatedData['name'];
            $social->url = $validatedData['url'];

            // Check if an icon file was uploaded
            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                $filename = $icon->getClientOriginalName();
                $path = $icon->storeAs('public/homepage/socials', $filename);
                $social->icon = '/storage/public/' . $path;
            }

            // Save the social
            $social->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Social updated successfully.',
                'data' => SocialResource::make($social)
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Failed to update social.',
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            // Get the social by ID
            $social = Social::findOrFail($id);

            // Delete the social's icon file if it exists
            if ($social->icon) {
                Storage::delete('public/homepage/socials/'.$social->icon);
            }

            // Delete the social
            $social->delete();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Social deleted successfully.',
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Failed to delete social.',
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }
}
