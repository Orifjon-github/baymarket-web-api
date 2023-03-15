<?php

namespace App\Http\Controllers;

use App\Models\OrderedProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::all();
            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to retrieve orders'], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // start transaction

        try {
            // validate the incoming request data
            $validatedData = $request->validate([
                'ClientName' => 'required|string',
                'Phone' => 'required|string',
                'Type' => 'required|in:delivery,pick up',
                'Address' => 'nullable|string',
                'Postcode' => 'nullable|integer',
                'Time' => 'nullable|date_format:d-m-Y H:i:s',
                'PaymentType' => 'required|in:debit card,cash',
                'Comment' => 'nullable|string',
                'TotalPrice' => 'required|numeric|min:0',
                'Products' => 'required|array|min:1',
                'Products.*.name' => 'required|string',
                'Products.*.description' => 'nullable|string',
                'Products.*.size_name' => 'nullable|string',
                'Products.*.size' => 'nullable|string',
                'Products.*.quantity' => 'required|integer|min:1',
                'Products.*.price' => 'required|numeric|min:0',
                'Products.*.total_product_price' => 'required|numeric|min:0',
            ]);

            // create a new order
            $order = new Order();
            do {
                $orderId = 'VNC-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            } while (Order::where('OrderID', $orderId)->exists()); // generate a unique order ID
            $order->OrderID = $orderId;
            $order->ClientName = $validatedData['ClientName'];
            $order->Phone = $validatedData['Phone'];
            $order->Type = $validatedData['Type'];
            $order->Address = $validatedData['Address'];
            $order->Postcode = $validatedData['Postcode'];
            $order->Time = $validatedData['Time'];
            $order->PaymentType = $validatedData['PaymentType'];
            $order->Comment = $validatedData['Comment'];
            $order->TotalPrice = $validatedData['TotalPrice'];
            $order->Status = 'Not Confirmed'; // default status
            $order->save();

            // save the ordered products
            foreach ($validatedData['Products'] as $product) {
                $orderedProduct = new OrderedProduct();
                $orderedProduct->order_id = $order->id;
                $orderedProduct->product = json_encode($product);
                $orderedProduct->save();
            }

            DB::commit(); // commit transaction

            // return success response with the saved order data
            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollback(); // rollback transaction
            // return error response with the error message and code
            return response()->json([
                'status' => 'error',
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $order = Order::with('products')->findOrFail($id);
//            $products = $order->products()->get();

            $orderData = [
                'ClientName' => $order->ClientName,
                'Phone' => $order->Phone,
                'Type' => $order->Type,
                'Address' => $order->Address,
                'Postcode' => $order->Postcode,
                'Time' => $order->Time,
                'PaymentType' => $order->PaymentType,
                'Comment' => $order->Comment,
                'TotalPrice' => $order->TotalPrice,
                'Products' => $order->products->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'description' => $product->description,
                        'size_name' => $product->size_name,
                        'size' => $product->size,
                        'quantity' => $product->quantity,
                        'price' => $product->price,
                        'total_product_price' => $product->total_product_price
                    ];
                })->toArray()
            ];

            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Order retrieved successfully.',
                'data' => $orderData
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Order not found.'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Error retrieving order details.'
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'ClientName' => 'required|string|max:255',
            'Phone' => 'required|string|max:255',
            'Type' => 'required|string|in:delivery,pick up',
            'Address' => 'nullable|string',
            'Postcode' => 'nullable|integer',
            'Time' => 'nullable|date_format:d-m-Y H:i:s',
            'PaymentType' => 'required|string|in:debit card,cash',
            'Comment' => 'nullable|string',
            'Status' => 'required|string|in:Not Confirmed,Confirmed,Canceled,Delivered,Pick uped'
        ]);

        // Find the Order by ID
        $order = Order::find($id);

        // If the Order does not exist, return an error response
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Order not found'
            ], 404);
        }

        // Update the Order with the validated data
        $order->update($validatedData);

        // Return a success response
        return response()->json([
            'status' => 'success',
            'code' => 0,
            'message' => 'Order updated successfully'
        ]);
    }


    public function destroy($id)
    {
        try {
            // Find the order by ID
            $order = Order::findOrFail($id);

            // Delete the order
            $order->delete();

            return response()->json([
                'status' => 'success',
                'code' => 0,
                'message' => 'Order deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }

}
