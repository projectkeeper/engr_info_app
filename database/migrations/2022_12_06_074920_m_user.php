<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_users', function (Blueprint $table) {
           $table -> increments('id');
           $table -> string('first_name');
           $table -> string('family_name');
           $table -> string('email');
           $table -> string('age');
           $table -> string('gender');
           $table -> string('login_id');
           $table -> string('login_pass');
           $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('m_users');
    }
};
