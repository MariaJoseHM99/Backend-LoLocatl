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

    public static function getCategoryById(){  
        $category = Category::find($this->$categoryId); 
        if (Category::where("categoryId", $this->$categoryId)->count() == 0) 
        {
            return response()->json([
                'message' => 'The category doesn´t exit'
            ]);
        }else {
            return $category; 
        }  
    }

    public static function getcategoryByName(string $nameCategory){
        $category = Category::where("nameCategory", "LIKE", $nameCategory . "%")->get();
        if (count($category)>0) {
            return $category;
        }else{
            return response()->json([
                'message' => 'The user doesn´t exit'
            ]);
        } 
    }

    public function getAllCategories() {
        return $this::with('nameCategory')->get();
    }
}