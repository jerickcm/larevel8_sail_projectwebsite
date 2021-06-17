<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserrnamePimgToUserdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('user_details', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('cover_photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('profile_picture');
            $table->dropColumn('cover_photo');
        });
    }
}
