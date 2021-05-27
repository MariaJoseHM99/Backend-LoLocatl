<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Tttp\Token;
use App\Enums\AttentionDay;
use App\Enums\NumberType;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Models\Business;
use App\Models\User;
use App\Models\PhoneNumber;


class BusinessController extends Controller
{
    public function createCategory(Request $request)
    {
        $request->validate([
            'nameCategory' => 'required|string'
        ]);
        
        try{
        $category = new category();
        $category->nameCategory = $request->input("nameCategory");
        $category->saveCategory();

        return response()->json([
            "status" => "success",
            'message' => 'Category created successfully!'
        ], 201);

        }catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function registerBusiness(Request $request) {
        $request->validate([
            'businessName' => 'required|string',
            'businessDescription' => 'required|string',
            'categoryId' => 'required|integer'
        ]);
    
        try{
            $business = new Business();
            $user = $request->user();
            $userId = $user->userId;
            $business->userId = $userId;
            $business->categoryId = Category::find($request->input("categoryId"))->categoryId;
            $business->businessName = $request->input("businessName");
            $business->businessSlug = Business::getSlugName($request->input("businessName"));
            $business->businessDescription = $request->input("businessDescription");

            $business->saveBusiness();

            return response()->json([
                "status" => "success",
                'message' => 'Business created successfully!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }


    public function createScheduleDay(Request $request, int $businessId)
    {
        $request->validate([
            'attentionDay' => 'required|integer',
            'timetable' => 'required|integer'

        ]);
        
        try{
        $scheduleDay = new ScheduleDay();
        $scheduleDay->attentionDay = $request->input("attentionDay");
        $scheduleDay->timetable = $request->input("timetable");
        $scheduleDay->businessId = $businessId;
        $scheduleDay->saveScheduleDay();

        return response()->json([
            "status" => "success",
            'message' => 'Schedule Day created successfully!'
        ], 201);

        }catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }


    public function registerPhoneNumber(Request $request, int $businessId)
    {
        $request->validate([
            'phoneNumber' => 'required|string',
            'numberType' => 'required|integer'
        ]);
        
        try{
        $phoneNumber = new PhoneNumber();
        $phoneNumber->phoneNumber = $request->input("phoneNumber");
        $phoneNumber->numberType = $request->input("numberType");
        $phoneNumber->businessId = $businessId;
        $phoneNumber->savePhoneNumber();

        return response()->json([
            "status" => "success",
            'message' => 'Phone Number registered successfully!'
        ], 201);

        }catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }

}
  
