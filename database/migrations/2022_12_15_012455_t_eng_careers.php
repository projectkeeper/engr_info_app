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
      Schema::create('t_eng_careers', function (Blueprint $table) {
        $table->string('email', 100);
        $table->string('base_info_id', 100);
        $table->string('career_info_id', 100);
        $table->string('pj_outline', 200);
        $table->string('role', 50);
        $table->string('task', 200);
        $table->string('pj_dev_env', 200);
        $table->string('period_from', 200);
        $table->string('period_to', 200);
        $table->timestamps();

        //PK設定
        $table->primary(['login_id','base_info_id','career_info_id']);
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      //t_eng_careersをドロップ
      Schema::dropIfExists('t_eng_careers');
    }
};
