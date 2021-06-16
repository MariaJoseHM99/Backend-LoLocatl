<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;



class Business extends Model {
    use HasFactory;


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
    protected $primaryKey = "id";

    /**
     * True if there are columns for creation and update dates.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function getAllBusiness() {
        return $this::with('phoneNumbers')->get();
    }

    public function getBusinessBySlug($businessSlug) {
        return $this::with(['phoneNumbers', 'category'])->where('businessSlug', $businessSlug)->first();
    }

    public function saveBusiness() {
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving business.");
        }
    }

    public static function geBusinesstById($businessId) {
        return static::find($businessId);
     }

    public static function getSlugName($businessName){
        $businessSlug = Str::of($businessName)->slug("-");

        return $businessSlug;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function phoneNumbers() {
        return $this->hasMany(PhoneNumber::class);
    }

    public static function createBusiness($userId, $categoryId, $businessName, $businessDescription, $phoneNumbers){

        try{
            DB::beginTransaction();
            $business = new Business();
            $business->userId = $userId;
            $business->categoryId = $categoryId;
            $business->businessName = $businessName;
            $business->businessSlug = Business::getSlugName($businessName);
            $business->businessDescription = $businessDescription;

            $business->saveBusiness();

            foreach($phoneNumbers as $number) {
                $phoneNumber = new PhoneNumber();
                $phoneNumber->phoneNumber = $number["phoneNumber"];
                $phoneNumber->numberType = $number["numberType"];
                $business->phoneNumbers()->save($phoneNumber);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        } 
    }

    public function getReviews(){
        if (Business::where("businessId", $this->businessId)->count() == 0) {
            return response()->json([
                'message' => 'The business doesn´t exit'
            ]);
        }else{
            $review = Review::orderBy("publish_date","DESC")->where("businessId", $this->businessId)->get();
            return response()->json(
                $review
            ); 
        }                 
    }
}
