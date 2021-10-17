<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description');
            $table->unsignedInteger('salary_from');
            $table->unsignedInteger('salary_to');
            $table->unsignedBigInteger('requirement_id')->nullable();
            $table->foreign('requirement_id')
            ->references('id')
            ->on('requirements')
            ->onDelete('cascade');
            $table->unsignedBigInteger('hirer_id');
            $table->foreign('hirer_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->date('apply_until');
            $table->string('social');
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
        Schema::dropIfExists('job_posts');
    }
}
