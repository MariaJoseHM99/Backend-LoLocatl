<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;


    /**
     * Table in database.
     *
     * @var string
     */
    protected $table = "user";

    /**
     * Primary key in table.
     *
     * @var string
     */
    protected $primaryKey = "userId";