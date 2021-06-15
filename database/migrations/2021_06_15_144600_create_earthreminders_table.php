<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarthremindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earthreminders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('author')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->date('event_date')->nullable(); //' YYYY-MM-DD
            $table->string('country')->nullable();
            $table->string('slug')->nullable();
            $table->integer('publish')->default(1);
            $table->string('publish_text')->nullable()->default('draft');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('ckeditor_log')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('earthreminders');
    }
}
