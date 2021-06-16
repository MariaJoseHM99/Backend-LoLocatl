<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Tttp\Token;
use App\Models\Business;
use App\Models\Review;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getAllCategories(Request $request): JsonResponse
    {
        try {
            $category = new Category();
            $categories = $category->getAllCategories();

            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}