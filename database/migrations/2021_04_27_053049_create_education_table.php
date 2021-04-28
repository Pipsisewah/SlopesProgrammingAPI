<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('institution')->unique();
            $table->string('area');
            $table->string('study_type');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('gpa')->nullable();
            $table->timestamps();
        });
        Schema::create('education_user', function (Blueprint $table) {
            $table->id();
            $table->integer("education_id");
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('education');
        Schema::dropIfExists('education_user');
    }
}
