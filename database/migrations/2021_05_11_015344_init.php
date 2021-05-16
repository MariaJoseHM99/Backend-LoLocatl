<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user", function (Blueprint $table) {
            $table->increments("userId");
            $table->string("password");
            $table->string("name", 25);
            $table->string("lastName", 40);
            $table->string("email")->unique();
            $table->string("address", 100);
            $table->string("cellphoneNumber", 10)->nullable();

        });

        Schema::create("schedule", function (Blueprint $table) {
            $table->increments("scheduleId");
            $table->string('timetable',100);
        });

        Schema::create("scheduleDay", function (Blueprint $table) {
            $table->increments("scheduleDayId");
            $table->integer("attentionDay"); // AttentionDay
            $table->foreign("scheduleId")->references("scheduleId")->on("schedule");
            $table->integer("scheduleId")->unsigned();
        });

        Schema::create("category", function (Blueprint $table) {
            $table->increments("categoryId");
            $table->string('nameCategory',25);
        });

        Schema::create("business", function (Blueprint $table) {
            $table->increments("businessId");
            $table->string("businessName", 50)->unique();
            $table->string("cellphoneNumber", 10)->nullable();
            $table->string("businessDescription", 100);
            $table->integer("categoryId")->unsigned();
            $table->foreign("categoryId")->references("categoryId")->on("category");
            $table->integer("scheduleId")->unsigned();
            $table->foreign("scheduleId")->references("scheduleId")->on("schedule");
            $table->integer("userId")->unsigned();
            $table->foreign("userId")->references("userId")->on("user");
        });
        
        Schema::create("review", function (Blueprint $table) {
            $table->increments("reviewId");
            $table->date('publishDate')->nullable();
            $table->string('comment',100)->nullable();
            $table->integer('stars')->unsigned();
            $table->integer("userId")->unsigned();
            $table->foreign("userId")->references("userId")->on("user");
            $table->integer("businessId")->unsigned();
            $table->foreign("businessId")->references("businessId")->on("business");
        });
            
        
        Schema::Create("photo", function (Blueprint $table){
            $table->increments("photo_id");
            $table->string("imageStoragePath");  
            $table->integer("businessid")->unsigned();
            $table->foreign("businessid")->references("businessId")->on("business");  
        });

    }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists("photo");
            Schema::dropIfExists("schedule");
            Schema::dropIfExists("category");
            Schema::dropIfExists("review");
            Schema::dropIfExists("business");
            Schema::dropIfExists("user");
        }
}

