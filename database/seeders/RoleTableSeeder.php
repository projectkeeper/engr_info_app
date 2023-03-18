<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_name' => 'PG',
            'item_value'=> '0',
            'status'=> '0',
            'display_order' => 0,
          ];

          DB::table('m_roles') -> insert($param);

          $param = [
            'item_name' => 'SE',
            'item_value'=> '1',
            'status'=> '0',
            'display_order' => 1,
          ];

          DB::table('m_roles') -> insert($param);

          $param = [
            'item_name' => 'Team Lead',
            'item_value'=> '2',
            'status'=> '0',
            'display_order' => 2,
          ];

          DB::table('m_roles') -> insert($param);

          $param = [
            'item_name' => 'PMO',
            'item_value'=> '3',
            'status'=> '0',
            'display_order' => 3,
          ];

          DB::table('m_roles') -> insert($param);

          $param = [
            'item_name' => 'Other',
            'item_value'=> '4',
            'status'=> '0',
            'display_order' => 4,
          ];

          DB::table('m_roles') -> insert($param);
    }
}
