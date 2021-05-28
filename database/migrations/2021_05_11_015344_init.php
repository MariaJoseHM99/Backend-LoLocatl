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

        Schema::create("category", function (Blueprint $table) {
            $table->increments("categoryId");
            $table->string('nameCategory',25);
        });

        Schema::create("business", function (Blueprint $table) {
            $table->id();
            $table->string("businessName", 50)->unique();
            $table->string("businessSlug", 50)->unique();
            $table->string("businessDescription", 100);
            $table->integer("categoryId")->unsigned();
            $table->foreign("categoryId")->references("categoryId")->on("category");
            $table->integer("userId")->unsigned();
            $table->foreign("userId")->references("userId")->on("user");
        });

        Schema::create("scheduleDay", function (Blueprint $table) {
            $table->increments("scheduleDayId");
            $table->integer("attentionDay"); // Lunes, Lunes,
            $table->string('timetable',100); //  17-21, 9-15,
            $table->unsignedBigInteger("business_id")->unsigned();
            $table->foreign("business_id")->references("id")->on("business");
        });

        Schema::create("phoneNumber", function(Blueprint $table){
            $table->increments("phoneNumberId");
            $table->string("phoneNumber",10)->unique();
            $table->enum("numberType", [0, 1]); //NUMBERTYPE
            $table->unsignedBigInteger("business_id")->unsigned();
            $table->foreign("business_id")->references("id")->on("business");
        });

        Schema::create("review", function (Blueprint $table) {
            $table->increments("reviewId");
            $table->date('publishDate')->nullable();
            $table->string('comment',100)->nullable();
            $table->integer('stars')->unsigned();
            $table->integer("userId")->unsigned();
            $table->foreign("userId")->references("userId")->on("user");
            $table->unsignedBigInteger("business_id")->unsigned();
            $table->foreign("business_id")->references("id")->on("business");
        });


        Schema::Create("photo", function (Blueprint $table){
            $table->increments("photo_id");
            $table->string("imageStoragePath");
            $table->unsignedBigInteger("business_id")->unsigned();
            $table->foreign("business_id")->references("id")->on("business");
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down() {
        Schema::dropIfExists("photo");
        Schema::dropIfExists("review");
        Schema::dropIfExists("phoneNumber");
        Schema::dropIfExists("scheduleDay");
        Schema::dropIfExists("business");
        Schema::dropIfExists("category");
        Schema::dropIfExists("user");
    }
}

