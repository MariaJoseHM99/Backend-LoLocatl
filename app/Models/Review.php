<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;


class Review extends Model {
    use HasFactory;

    /**
     * Table in database.
     *
     * @var string
     */
    protected $table = "review";

    /**
     * Primary key in table.
     *
     * @var string
     */
    protected $primaryKey = "reviewId";

    public function saveReview() {
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving review.");
        }
    }
}