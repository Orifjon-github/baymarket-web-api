<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
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
            $product = Product::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Product retrieved successfully.',
                'data' => ProductResource::make($product)
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
        $is_image = true;

        if (is_string($request->image)) {
            $is_image = false;
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            "image" => ($is_image) ? 'required|image|mimes:jpeg,png,jpg,svg|max:2048' : 'string',
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
            if ($is_image) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('products', $file, $filename);
            } else {
                $path = $request->image;
            }

            $input = json_decode($request->input('size'), true);
            $size = array_map(function ($item) {
                return [
                    "id" => $item["id"],
                    "name" => $item["name"],
                    "size" => $item["size"],
                    "price" => $item["price"],
                ];
            }, $input);

            $product = new Product([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'image' => $path,
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
            $product = Product::findOrFail($id);

            $is_image = false;

            if ($request->hasFile('image')) {
                $is_image = true;
            }

            // Validate the request data
            $validatedData = $request->validate([
                'category_id' => 'required|integer',
                'name' => 'required|string|max:255',
                "image" => ($is_image) ? 'required|image|mimes:jpeg,png,jpg,svg|max:2048' : 'string',
                'description' => 'required|string',
                'time' => 'nullable|integer',
                'size' => 'required',
                'sub_title' => "nullable"
            ]);


            if ($is_image) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('products', $file, $filename);
            } else {
                $path = $request->image;
            }

            $array = json_decode($request->size, true);
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->time = $request->time;
            $product->size = serialize($array);
            $product->sub_title = $request->sub_title;
            $product->image = $path;

            $product->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Product updated successfully.',
                'data' => ProductResource::make($product)
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Failed to update Product.',
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            // Get the social by ID
            $product = Product::findOrFail($id);

            // Delete the social's icon file if it exists
            if ($product->icon) {
                Storage::delete('public/products/'.$product->icon);
            }

            // Delete the social
            $product->delete();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Product deleted successfully.',
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Failed to delete product.',
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }
}
