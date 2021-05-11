<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;


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