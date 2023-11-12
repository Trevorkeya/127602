<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;



return new class extends Migration {
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); 
            $table->string('phone_number')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        $instructors = DB::table('users')->where('type', 2)->get();

        foreach ($instructors as $instructor) {
           
            $phoneNumber = $instructor->phone_number ?? null; 

            DB::table('instructors')->insert([
                'user_id' => $instructor->id,
                'phone_number' => $phoneNumber, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('instructors');
    }
};
