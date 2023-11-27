<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (!function_exists('generateAdmissionNumber')) {
    function generateAdmissionNumber()
    {
        return rand(1001, 9999);
    }
}

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); 
            $table->string('admission_number', 4)->unique();
            $table->string('phone_number')->nullable();
            $table->timestamps();

            
            $table->foreign('user_id')->references('id')->on('users');
        });

        
        $students = DB::table('users')->where('type', 0)->get();

        
        foreach ($students as $student) {
            $phoneNumber = $student->phone_number ?? null; 

            DB::table('students')->insert([
                'user_id' => $student->id,
                'admission_number' => generateAdmissionNumber(),
                'phone_number' => $phoneNumber, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
