<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;


class Category extends Model {
    use HasFactory;

    protected $fillable = [
        'nameCategory',
    ];

    /**
     * Table in database.
     *
     * @var string
     */
    protected $table = "category";

    /**
     * Primary key in table.
     *
     * @var string
     */
    protected $primaryKey = "categoryId";

    /**
     * True if there are columns for creation and update dates.
     *
     * @var boolean
     */
    public $timestamps = false;


    public function saveCategory() {
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving category.");
        }
    }

    public static function getCategoryById(int $categoryId){  
        $category = Category::find($categoryId); 
        if (Category::where("categoryId", $categoryId)->count() == 0) 
        {
            return response()->json([
                'message' => 'The category doesn´t exit'
            ]);
        }else {
            return $category; 
        }  
    }

    public static function getuserByName(string $nameCategory){
        $category = Caregory::where("nameCategory", $nameCategory)->get()->first();
        if ($category == null) {
            throw new \Exception("Category not found.");
        }
        return $category;
    }
}