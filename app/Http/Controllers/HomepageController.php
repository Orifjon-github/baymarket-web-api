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
use Illuminate\Http\JsonResponse;

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
}
