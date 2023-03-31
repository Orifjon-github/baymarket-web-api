<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function index() {
        try {
            $partnership = Partnership::all();
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Partnerships retrieved successfully.',
                'data' => $partnership
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id) {
        try {
            $partnership = Partnership::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Partnership retrieved successfully.',
                'data' => $partnership
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request) {
        try {
            $partnership = new Partnership([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? null,
                'phone' => $request->phone,
                'email' => $request->email ?? null,
                'message' => $request->message
            ]);
            $partnership->save();
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Partnership saved successfully.',
                'data' => $partnership
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 3,
                'message' => $e->getMessage()
            ]);
        }
    }
}
