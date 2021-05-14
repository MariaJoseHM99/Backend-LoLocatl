<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password',
    ];

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

    /**
     * True if there are columns for creation and update dates.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "password"
    ];

    public function saveUser() {
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving user.");
        }
    }

    public static function getuserByEmail(string $email){
        $user = user::where("email", $email)->get()->first();
        if ($user == null) {
            throw new \Exception("User not found.");
        }
        return $user;
    }

    public function saveToken(){
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving user.");
        }
    }

}