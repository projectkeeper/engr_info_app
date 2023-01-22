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
        //t_eng_bases(エンジニア基本情報)テーブル定義
        Schema::create('t_eng_bases', function (Blueprint $table) {
        $table->string('login_id', 100);
        $table->integer('base_info_id', 10);
        $table->string('family_name', 100);
        $table->string('first_name', 100);
        $table->string('family_name_kana', 100);
        $table->string('first_name_kana', 100);
        $table->string('certificates', 200);
        $table->string('exprience_periods', 50);
        $table->string('station_nearby', 50);
        $table->string('OS', 200);
        $table->string('PG_Lang', 200);
        $table->string('dev_env', 200);
        $table->string('data_status', 50);
        $table->timestamps();

        //PK設定
        $table->primary(['login_id','base_info_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //t_eng_basesをドロップ
        Schema::dropIfExists('t_eng_bases');
    }
};
