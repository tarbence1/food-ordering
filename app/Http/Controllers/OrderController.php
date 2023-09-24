<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MenuOrder;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function order(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'restaurantId' => 'required|integer|exists:restaurants,id',
            'customerId' => 'required|integer|exists:users,id',
            'items' => 'required|array',
            'items.*.menuId' => 'required|integer|exists:menu,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        $restaurant = Restaurant::find($request->input('restaurantId'));
        $user = User::find($request->input('customerId'));

        if (is_null($restaurant)) {
            return response()->json([
                'error' => 'Restaurant not found'
            ], 404);
        }

        if (is_null($user) || auth()->user()->id !== $user->id) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }


        try {
            $order = Order::create([
                'customerId' => $user->id,
                'restaurantId' => $restaurant->id,
            ]);


            $menuOrder = $request->input('items');
            foreach ($menuOrder as $item) {
                $order->menu()->attach(
                    $item['menuId'],
                    [
                        'quantity' => $item['quantity'],
                        'instructions' => $item['instructions']
                    ]
                );
            }
            $order->save();
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }


        return response()->json([
            'id' => $order->id
        ]);

    }

    public function orders(Request $request): JsonResponse
    {
        $owner = auth()->user();
        $ownersRestaurant = $owner->restaurant;

        if (is_null($ownersRestaurant)) {
            return response()->json([
                'error' => 'You are not a restaurant owner'
            ], 403);
        }

        $restaurantOrders = Order::where('restaurantId', $ownersRestaurant->id)->get();

        $orders = [];
        foreach ($restaurantOrders as $order) {
            $orderMenu = MenuOrder::where('order_id', $order->id)->get();
            $orderItems = [];
            foreach ($orderMenu as $item) {
                $orderItems[] = [
                    'menuId' => $item->menu_id,
                    'quantity' => $item->quantity,
                    'instructions' => $item->instructions,
                ];
            }

            $orders[] = [
                'id' => $order->id,
                'status' => $order->status,
                'customerId' => $order->customerId,
                'customerName' => $order->customer->name,
                'customerEmail' => $order->customer->email,
                'items' => $orderItems
            ];
        }

        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function update(Request $request, int $orderId): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:'
                . Order::STATUS_RECEIVED . ','
                . Order::STATUS_PREPARING . ','
                . Order::STATUS_READY . ','
                . Order::STATUS_DELIVERED
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        $owner = auth()->user();
        $ownersRestaurant = $owner->restaurant;

        if (is_null($ownersRestaurant)) {
            return response()->json([
                'error' => 'You are not a restaurant owner'
            ], 403);
        }

        $order = Order::find($orderId);

        if (is_null($order) || $order->restaurantId !== $ownersRestaurant->id) {
            return response()->json([
                'error' => 'Order not found'
            ], 404);
        }

        try {
            $order->status = $request->input('status');
            $order->save();
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'id' => $order->id,
            'status' => $order->status,
        ]);

    }

    public function details(Request $request, int $orderId): JsonResponse
    {
        $owner = auth()->user();
        $ownersRestaurant = $owner->restaurant;

        if (is_null($ownersRestaurant)) {
            return response()->json([
                'error' => 'You are not a restaurant owner'
            ], 403);
        }

        $order = Order::find($orderId);

        if (is_null($order) || $order->restaurantId !== $ownersRestaurant->id) {
            return response()->json([
                'error' => 'Order not found'
            ], 404);
        }

        $orderMenu = MenuOrder::where('order_id', $order->id)->get();
        $orderItems = [];
        foreach ($orderMenu as $item) {
            $orderItems[] = [
                'menuId' => $item->menu_id,
                'quantity' => $item->quantity,
                'instructions' => $item->instructions,
            ];
        }

        return response()->json([
            'id' => $order->id,
            'status' => $order->status,
            'customerId' => $order->customerId,
            'customerName' => $order->customer->name,
            'customerEmail' => $order->customer->email,
            'items' => $orderItems
        ]);
    }

}
