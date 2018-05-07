<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoutesPrefixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PRMSN_routes_prefixes', function (Blueprint $table){
           $table->increments('id');
           $table->string('link')->unique();
           $table->string('prefix')->unique();
           $table->unsignedInteger('created_by');
           $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('PRMSN_routes_prefixes');
    }
}
