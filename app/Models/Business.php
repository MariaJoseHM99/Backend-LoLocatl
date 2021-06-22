<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class Business extends Model
{
    use HasFactory;


    /**
     * True if there are columns for creation and update dates.
     *
     * @var boolean
     */
    public $timestamps = false;
    /**
     * Table in database.
     *
     * @var string
     */
    protected $table = "business";
    /**
     * Primary key in table.
     *
     * @var string
     */
    protected $primaryKey = "businessId";

    public static function geBusinesstById($businessId)
    {
        return static::find($businessId);
    }

    public static function createBusiness($userId, $categoryId, $businessName, $businessDescription, $phoneNumbers)
    {
        try {
            DB::beginTransaction();
            $business = new Business();
            $business->userId = $userId;
            $business->categoryId = $categoryId;
            $business->businessName = $businessName;
            $business->businessSlug = Business::getSlugName($businessName);
            $business->businessDescription = $businessDescription;
            $business->saveBusiness();


            foreach ($phoneNumbers as $number) {
                $phoneNumber = new PhoneNumber();
                $phoneNumber->businessId = $business->businessId;
                $phoneNumber->phoneNumber = $number["phoneNumber"];
                $phoneNumber->numberType = $number["numberType"];
                $phoneNumber->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function getSlugName($businessName)
    {
        $businessSlug = Str::of($businessName)->slug("-");

        return $businessSlug;
    }

    public function saveBusiness()
    {
        if (!$this->save()) {
            throw new Exception("An error occurred on saving business.");
        }
    }

    public function getAllBusiness()
    {
        return $this::with('phoneNumbers')->get();
    }

    public function getBusinessBySlug($businessSlug)
    {
        return $this::with(['phoneNumbers', 'category'])->where('businessSlug', $businessSlug)->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class, "businessId");
    }

    public function getReviews()
    {
        if (Business::where("businessId", $this->businessId)->count() == 0) {
            return response()->json([
                'message' => 'The business doesn´t exit'
            ]);
        } else {
            $review = Review::orderBy("publish_date", "DESC")->where("businessId", $this->businessId)->get();
            return response()->json(
                $review
            );
        }
    }

    public function getBusinessByUserId() 
    {
        if (Business::where("userId", $this->userId)->count() == 3) {
            return true;
        } else {
            return false;
        }
    }
}
