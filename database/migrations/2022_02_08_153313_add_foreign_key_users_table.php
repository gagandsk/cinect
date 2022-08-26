<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('profile_image_id')->unsigned();
            $table->foreign('profile_image_id')->references('id')->on('profile_images');
            $table->bigInteger('fav_genre_id')->unsigned();
            $table->foreign('fav_genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_profile_image_id_foreign');
            $table->dropForeign('users_fav_genre_id_foreign');
        });
    }
}
