<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('author')->nullable();
            $table->string('message')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->integer('publish')->default(1);
            $table->string('publish_text')->nullable()->default('draft');
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('quotes');
    }
}
