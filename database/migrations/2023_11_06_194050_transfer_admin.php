<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;



return new class extends Migration {
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); 
            $table->string('phone_number')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        $administrators = DB::table('users')->where('type', 1)->get();

        foreach ($administrators as $administrator) {
           
            $phoneNumber = $administrator->phone_number ?? null; 

            DB::table('administrators')->insert([
                'user_id' => $administrator->id,
                'phone_number' => $phoneNumber, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('administrators');
    }
};
