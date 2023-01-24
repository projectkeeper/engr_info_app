<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MDevEnvValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $param = [
        'item_name' => 'Apache',
        'item_value'=> '0',
        'owner' => 'common',
        'status'=> '0',
        'display_order' => 0,
      ];

      DB::table('m_dev_env_values') -> insert($param);

      $param = [
        'item_name' => 'NgynX',
        'item_value'=> '1',
        'owner' => 'common',
        'status'=> '0',
        'display_order' => 1,
      ];

      DB::table('m_dev_env_values') -> insert($param);


      $param = [
        'item_name' => 'Tomcat',
        'item_value'=> '2',
        'owner' => 'common',
        'status'=> '0',
        'display_order' => 2,
      ];

      DB::table('m_dev_env_values') -> insert($param);

      $param = [
        'item_name' => 'Amazon(EC2)',
        'item_value'=> '3',
        'owner' => 'common',
        'status'=> '0',
        'display_order' => 3,
      ];

      DB::table('m_dev_env_values') -> insert($param);

      $param = [
        'item_name' => 'Unicorn',
        'item_value'=> '4',
        'owner' => 'common',
        'status'=> '0',
        'display_order' => 4,
      ];

      DB::table('m_dev_env_values') -> insert($param);

      $param = [
        'item_name' => 'その他',
        'item_value'=> '5',
        'owner' => 'common',
        'status'=> '0',
        'display_order' => 5,
      ];

      DB::table('m_dev_env_values') -> insert($param);
    }
}
