<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Tttp\Token;
use App\Enums\AttentionDay;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Models\Business;
use App\Models\User;




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

    public function createSchedule(Request $request)
    {
        $request->validate([
            'timetable' => 'required|string'
        ]);
        
        try{
        $schedule = new schedule();
        $schedule->timetable = $request->input("timetable");
        $schedule->saveSchedule();

        return response()->json([
            "status" => "success",
            'message' => 'Schedule created successfully!'
        ], 201);

        }catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
        }
    }


    public function createScheduleDay(Request $request, int $scheduleId)
    {
        $request->validate([
            'attentionDay' => 'required|integer'

        ]);
        
        try{
        $scheduleDay = new ScheduleDay();
        $scheduleDay->attentionDay = $request->input("attentionDay");
        $scheduleDay->scheduleId = $scheduleId;
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

    public function registerBusiness(Request $request) {
        $request->validate([
            'businessName' => 'required|string',
            'cellphoneNumber' => 'required|string',
            'businessDescription' => 'required|string',
            'categoryId' => 'required|integer',
            'scheduleId' => 'required|integer'
        ]);
    
        try{
            $business = new Business();
            $user = $request->user();
            $userId = $user->userId;
            $business->userId = $userId;
            $business->categoryId = Category::find($request->input("categoryId"))->categoryId;
            $business->scheduleId = Schedule::find($request->input("scheduleId"))->scheduleId;
            $business->businessName = $request->input("businessName");
            $business->cellphoneNumber = $request->input("cellphoneNumber");
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
}
  
