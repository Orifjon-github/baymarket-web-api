<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdditionalProductResource;
use App\Http\Resources\CarouselResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SpecialResource;
use App\Http\Resources\TestimonialResource;
use App\Models\AdditionalProduct;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Product;
use App\Models\Settings\Setting;
use App\Models\Special;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomepageController extends Controller
{

    public function settings(): JsonResponse
    {
        $settings = new SettingResource(Setting::first());
        return response()->json([
           'success' => true,
           'code' => 200,
           'message' => 'OK',
           'data' => $settings
        ]);
    }
    public function categories(): JsonResponse
    {
        $categories = CategoryResource::collection(Category::all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $categories
        ]);
    }
    public function products(): JsonResponse
    {
        $products = ProductResource::collection(Product::all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $products
        ]);
    }

    public function showCategory($id): JsonResponse
    {
        $products = ProductResource::collection(Category::find($id)->products);
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $products
        ]);
    }
    public function specials(): JsonResponse
    {
        $specials = SpecialResource::collection(Special::all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $specials
        ]);
    }

    public function additionalProducts(): JsonResponse
    {
        $additional_products = AdditionalProductResource::collection(AdditionalProduct::all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $additional_products
        ]);
    }
    public function carousels(): JsonResponse
    {
        $carousels = CarouselResource::collection(Carousel::all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $carousels
        ]);
    }
    public function popularRecipes(): JsonResponse
    {
        $products = ProductResource::collection(Product::where("category_id", 1)->get()->random(5));
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $products
        ]);
    }
    public function testimonials(): JsonResponse
    {
        $testimonials = TestimonialResource::collection(Testimonial::all()->random(3));
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $testimonials
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // If the credentials are invalid, return an error response
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
        ], 200);
    }
}
