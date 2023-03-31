<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $categories = Category::all();
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Categories retrieved successfully.',
                'data' => CategoryResource::collection($categories)
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
            $category = Category::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Category retrieved successfully.',
                'data' => CategoryResource::make($category)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            "url" => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 2,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $file = $request->file('url');
            $filename = $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('homepage/categories', $file, $filename);

            $category = new Category([
                'name' => $request->name,
                'url' => $path
            ]);
            $category->save();
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Category saved successfully.',
                'data' => CategoryResource::make($category)
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
            // Get the category by ID
            $category = Category::findOrFail($id);

            $is_image = false;

            if ($request->hasFile('url') && is_file($request->url)) {
                $is_image = true;
            }

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                "url" => ($is_image) ? 'required|image|mimes:jpeg,png,jpg,svg|max:2048' : 'string',
            ]);

            if ($is_image) {
                $file = $request->file('url');
                $filename = $file->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('homepage/categories', $file, $filename);
            } else {
                $path = $request->url;
            }
            $category->name = $validatedData['name'];
            $category->url = $path;

            $category->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Category updated successfully.',
                'data' => CategoryResource::make($category)
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Failed to update category.',
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            // Get the category by ID
            $category = Category::findOrFail($id);

            // Delete the category's url file if it exists
            if ($category->url) {
                Storage::delete('public/homepage/categories/'.$category->url);
            }

            // Delete the category
            $category->delete();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Category deleted successfully.',
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Failed to delete category.',
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }
}
