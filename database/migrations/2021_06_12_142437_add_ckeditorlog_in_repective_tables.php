<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCkeditorlogInRepectiveTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('ckeditor_log')->nullable();
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('ckeditor_log')->nullable();
        });
        Schema::table('news', function (Blueprint $table) {
            $table->string('ckeditor_log')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('ckeditor_log');
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('ckeditor_log');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('ckeditor_log');
        });
    }
}
