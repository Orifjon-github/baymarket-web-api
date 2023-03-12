<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogoUpdateRequest;
use App\Http\Resources\LogoResource;
use App\Models\Settings\Logo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LogoController extends Controller
{

    public function index()
    {
        $logos = LogoResource::collection(Logo::all());
        return response()->json([
            'success' => true,
            'code' => 0,
            'data' => $logos
        ], 200);
    }

    public function show(Logo $logo)
    {
        try {
            return response()->json([
                'success' => true,
                'code' => 0,
                'data' => $logo
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'code' => 3,
                'message' => 'Logo not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Logo $logo): \Illuminate\Http\JsonResponse
    {
        try {
//            $validatedData = $request->validated();

            if ($request->hasFile('url')) {
                $file = $request->file('url');
                if ($file->isValid()) {
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs('/storage/homepage/logos', $filename);
                    if ($path) {
                        $logo->url = $path;
                    } else {
                        throw new \Exception('Failed to store file.');
                    }
                } else {
                    throw new \Exception('Invalid file.');
                }
            }

            // Update the logo with the validated data
            $logo->save();

            // Return a response indicating success
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Logo updated successfully.',
                'data' => LogoResource::make($logo)
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => 1,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'code' => 3,
                'message' => 'Logo not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(Logo $logo)
    {
        try {
            $logo->delete();
            return response()->json([
                'success' => true,
                'code' => 0,
                'message' => 'Logo deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'code' => 3,
                'message' => 'Logo not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
