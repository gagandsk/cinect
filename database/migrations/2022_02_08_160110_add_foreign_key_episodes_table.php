<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->bigInteger('serie_id')->unsigned();
            $table->foreign('serie_id')->references('id')->on('series');
            $table->bigInteger('anime_id')->unsigned();
            $table->foreign('anime_id')->references('id')->on('animes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropForeign('episodes_serie_id_foreign');
            $table->dropForeign('episodes_anime_id_foreign');            
        });
    }
}
