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
}
