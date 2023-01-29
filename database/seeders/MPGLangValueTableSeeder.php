<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MPGLangValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $param = [
        'item_name' => 'Java',
        'item_value'=> '0',
        'owner' => 'admin',
        'status'=> '0',
        'display_order' => 0,
      ];

      DB::table('m_pg_lang_values') -> insert($param);

      $param = [
        'item_name' => 'C/C++',
        'item_value'=> '1',
        'owner' => 'admin',
        'status'=> '0',
        'display_order' => 1,
      ];

      DB::table('m_pg_lang_values') -> insert($param);


      $param = [
        'item_name' => 'PHP',
        'item_value'=> '2',
        'owner' => 'admin',
        'status'=> '0',
        'display_order' => 2,
      ];

      DB::table('m_pg_lang_values') -> insert($param);

      $param = [
        'item_name' => 'PHP(FW)',
        'item_value'=> '3',
        'owner' => 'admin',
        'status'=> '0',
        'display_order' => 3,
      ];

      DB::table('m_pg_lang_values') -> insert($param);

      $param = [
        'item_name' => 'その他',
        'item_value'=> '4',
        'owner' => 'admin',
        'status'=> '0',
        'display_order' => 4,
      ];

      DB::table('m_pg_lang_values') -> insert($param);
        //
    }
}
