<?php

namespace App\Http\Controllers;
use Validator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Tttp\Token;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Models\Business;
use App\Models\PhoneNumber;
use App\Models\Photo;



class BusinessController extends Controller
{
    public function getAllBusiness(Request $request): JsonResponse
    {
        try {
            $business = new Business();
            $businesses = $business->getAllBusiness();

            return response()->json($businesses);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getBusinessBySlug(Request $request, $businessSlug): JsonResponse
    {
        try {
            $business = new Business();
            $business = $business->getBusinessBySlug($businessSlug);

            if ($business == null) {
                return response()->json([
                    "status" => "failure",
                    "message" => "No existe ese negocio"
                ], 500);
            }

            return response()->json($business);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function createCategory(Request $request): JsonResponse
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
        
        if (Business::getBusinessByUserId() == true) {
            return response()->json([
                'message' => 'You already have 3 registered business'
            ]);
        }
        
        $request->validate([
            'businessName' => 'required|string',
            'businessDescription' => 'required|string',
            'categoryId' => 'required|integer'
        ]);

        foreach($request->phoneNumbers as $phone){
            $validator = Validator::make($phone, [
                'phoneNumber' => 'required|string|unique:phoneNumber',
                'numberType' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => "failure",
                    "message" => "An error occurred on register phone number .", 
                ], 400);
            }  
        }

        try{
            $user = $request->user();
            Business::createBusiness(
                $user->userId,
                $request->input("categoryId"),
                $request->input("businessName"),
                $request->input("businessDescription"), 
                $request->input("phoneNumbers")
            );

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

    public function uploadPhoto(Request $request, int $businessId) {
        
        $request->validate([
            'imageStoragePath'=> 'required|image|max:2048'
        ]);

        try{
        $photo = new Photo();
        $photo->imageStoragePath = $request->file("imageStoragePath")->store( "", "photos");
        $photo->businessId = $businessId;
        $photo->savePhoto();

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully uploaded photo!' 
        ], 201);

        }catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}

