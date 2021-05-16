<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;


class Schedule extends Model {
    use HasFactory;

    /**
     * Table in database.
     *
     * @var string
     */
    protected $table = "schedule";

    /**
     * Primary key in table.
     *
     * @var string
     */
    protected $primaryKey = "scheduleId";

     /**
     * True if there are columns for creation and update dates.
     *
     * @var boolean
     */
    public $timestamps = false;


    public function saveSchedule() {
        if (!$this->save()) {
            throw new \Exception("An error occurred on saving schedule.");
        }
    }
}