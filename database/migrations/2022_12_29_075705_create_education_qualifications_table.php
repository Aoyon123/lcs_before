<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('qualification_name');
            $table->string('subject');
            $table->integer('passing_year');
            $table->float('result')->nullable();
            $table->unsignedBigInteger('user_id')->comment('Users Whoose Information Is This');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
