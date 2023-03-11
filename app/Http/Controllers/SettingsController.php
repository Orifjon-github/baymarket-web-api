<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Settings\Logo;
use App\Models\Settings\Setting;
use App\Models\Settings\SingleSettingItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = new SettingResource(Setting::first());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
            'data' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $setting = SingleSettingItem::first();
        $setting->update($request->all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Updates Saved Successfully',
        ]);
    }
}
