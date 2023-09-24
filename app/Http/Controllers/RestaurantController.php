<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function list(Request $request): JsonResponse
    {
        $restaurants = Restaurant::all();

        return response()->json([
            'restaurants' => $restaurants
        ]);

    }

    public function details(Request $request, int $id): JsonResponse
    {
        $restaurant = Restaurant::find($id);

        if (is_null($restaurant)) {
            return response()->json([
                'error' => 'Restaurant not found'
            ], 404);
        }

        $menu = $restaurant->menu;

        return response()->json([
            'restaurant' => $restaurant,
        ]);

    }

    public function menu(Request $request, int $id): JsonResponse
    {
        $restaurant = Restaurant::find($id);

        if (is_null($restaurant)) {
            return response()->json([
                'error' => 'Restaurant not found'
            ], 404);
        }

        $menu = $restaurant->menu;

        return response()->json([
            'menu' => $menu,
        ]);

    }

}
