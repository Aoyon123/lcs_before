<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Users Whoose Information Is This');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('education_level');
            $table->string('institute_name');
            $table->integer('passing_year');
            $table->string('certification_copy')->nullable();

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
        Schema::dropIfExists('education_qualifications');
    }
}
