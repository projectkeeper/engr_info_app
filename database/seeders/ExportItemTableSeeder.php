<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_category' => 'base',
            'item_name' => 'family_name',
            'item_value'=> 'D3',
            'status'=> '2',
            'display_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'first_name',
            'item_value'=> 'E3',
            'status'=> '2',
            'display_order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'family_name_kana',
            'item_value'=> 'D4',
            'status'=> '2',
            'display_order' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'first_name_kana',
            'item_value'=> 'E4',
            'status'=> '2',
            'display_order' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'certificates',
            'item_value'=> 'D5',
            'status'=> '2',
            'display_order' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'exprience_periods',
            'item_value'=> 'D6',
            'status'=> '2',
            'display_order' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'station_nearby',
            'item_value'=> 'D7',
            'status'=> '2',
            'display_order' => 7,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'OS',
            'item_value'=> 'D8',
            'status'=> '2',
            'display_order' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'dev_env',
            'item_value'=> 'D9',
            'status'=> '2',
            'display_order' => 9,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'base',
            'item_name' => 'PG_Lang',
            'item_value'=> 'D10',
            'status'=> '2',
            'display_order' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);




        $param = [
            'item_category' => 'career',
            'item_name' => '経歴No',
            'item_value'=> 'C',
            'status'=> '2',
            'display_order' => 11,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'career',
            'item_name' => 'pj_outline',
            'item_value'=> 'D',
            'status'=> '2',
            'display_order' => 12,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'career',
            'item_name' => 'role',
            'item_value'=> 'E',
            'status'=> '2',
            'display_order' => 13,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'career',
            'item_name' => 'task',
            'item_value'=> 'F',
            'status'=> '2',
            'display_order' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'career',
            'item_name' => 'pj_dev_env',
            'item_value'=> 'G',
            'status'=> '2',
            'display_order' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'career',
            'item_name' => 'period_from',
            'item_value'=> 'H',
            'status'=> '2',
            'display_order' => 16,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);

        $param = [
            'item_category' => 'career',
            'item_name' => 'period_to',
            'item_value'=> 'I',
            'status'=> '2',
            'display_order' => 17,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('m_export_items') -> insert($param);
    }
}
