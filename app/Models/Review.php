<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Review extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;

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