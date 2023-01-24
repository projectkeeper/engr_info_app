<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MOSValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $param = [
            'item_name' => 'Windows Series',
            'item_value'=> '0',
            'owner' => 'common',
            'status'=> '0',
            'display_order' => 0,
          ];

          DB::table('m_os_values') -> insert($param);

          $param = [
            'item_name' => 'RedHat Linux',
            'item_value'=> '1',
            'owner' => 'common',
            'status'=> '0',
            'display_order' => 1,
          ];

          DB::table('m_os_values') -> insert($param);


          $param = [
            'item_name' => 'Unix',
            'item_value'=> '2',
            'owner' => 'common',
            'status'=> '0',
            'display_order' => 2,
          ];

          DB::table('m_os_values') -> insert($param);

          $param = [
            'item_name' => 'Linux',
            'item_value'=> '3',
            'owner' => 'common',
            'status'=> '0',
            'display_order' => 3,
          ];

          DB::table('m_os_values') -> insert($param);

          $param = [
            'item_name' => 'その他',
            'item_value'=> '4',
            'owner' => 'common',
            'status'=> '0',
            'display_order' => 4,
          ];

          DB::table('m_os_values') -> insert($param);
    }
}
