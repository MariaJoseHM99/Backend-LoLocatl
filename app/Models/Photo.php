<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;



class Photo extends Model {
    use HasFactory;

    /**
     * Table in database.
     *
     * @var string
     */
    protected $table = "photo";

    /**
     * Primary key in table.
     *
     * @var string
     */
    protected $primaryKey = "photoId";

    /**
     * True if there are columns for creation and update dates.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function savePhoto() {
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving user.");
        }
    }
}