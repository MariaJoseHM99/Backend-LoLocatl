<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Tttp\Token;
use App\Models\Business;
use App\Models\Review;

class ReviewController extends Controller
{
    public function addReviewToBusiness(Request $request, int $businessId)
    {
        $request->validate([
            'comment'=> 'required|string',
            'stars'=> 'required|integer'
        ]);
        
        try{
        $review = new Review();
        $review->comment = $request->input("comment");
        $review->stars = $request->input("stars");
        $review->publish_date = date("Y-m-d h:i:s", time());
        $review->userId = $request->user()->user_id;
        $review->businessId = $businessId;

        $review->saveReview();

        return response()->json([
            "status" => "success",
            'message' => 'Review added successfully!'
        ], 201);

        }catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getBusinessReview(Request $request, int $businessId){
        $business = Business::getBusinessById($businessId); 
        $reviews = $business->getReviews();                  
    }
}