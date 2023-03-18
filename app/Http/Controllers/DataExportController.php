<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Illuminate\Support\Facades\Log;
use App\Models\t_eng_base;
use App\Models\m_export_item;

class DataExportController extends Controller
{
    /*
    * 経歴情報を作成し、エクセルに出力する
    */
    public function 
    export_career_history(Request $request){
      
      #エクセルのテンプレートファイルのPathを指示
      $excel_file = storage_path('app/Excel_format/Template_EngineerCareer.xlsx');

      //画面入力値を、全て取得する
      $params['email'] = $request->email;
      $params['base_info_id'] = $request->base_info_id;

      //Queryを作成する -> エンジニア情報（1人分）を取得する。
      $engineer_db_info = t_eng_base::getIndEngineerInfo($params)->get();

      //エクセルオブジェクト設定と出力データの設定
      $spreadsheet = self::set_export_data($excel_file, $engineer_db_info);

      //出力日付
      $export_date = now()->format('Y年m月d日'); //yyyy年m月dd日

      //エクセルファイルを、ローカルPCにダウンロードする
      #エクセルファイル名を設定
      $filename='engineer_career_history_'.$engineer_db_info[0]['family_name'].$engineer_db_info[0]['first_name'].'_'.$export_date.'.xlsx';

      #エクセルファイルをダウンロードするためのWriterのインスタンスを生成
      $writer = new WriterXlsx($spreadsheet);

      //headerの設定
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="'. $filename .'"');

      #エクセルファイルを、ダウンロードフォルダにダウンロードする
      $writer->save('php://output');

      #Viewに連携するデータを設定
      //$data = [
      //  'filename' => $filename, 'engineer_db_info' => $engineer_db_info,
      //];

      //return view('layout_section.layout_section_engineer.section_export_career_complete', $data);
    }

      /**
      エクセルテンプレートの読み込みと、出力値の設定
      */
      public static function 
      set_export_data($excel_file,$engineer_db_info){

      #エクセルのテンプレートファイルを取得
      $reader = new ReaderXlsx();
      $spreadsheet = $reader->load($excel_file);

      #エクセルのテンプレートファイル上の、アクティブシートオブジェクトの取得
      $sheet = $spreadsheet->getActiveSheet();

      /**
       基本(base)情報をエクセルに出力する
       */
      //基本情報の項目値を取得する
      $exp_items_base = m_export_item::CategoryEqual('base') -> get();

      //開発環境データを画面表示用の配列に設定する
//      foreach($exp_items as $exp_item){
//        $export_item_collection[$exp_item['item_name']] = $exp_item['item_value'];
//      }

      //エクセル上の基本情報蘭の値を設定する
      //サンプル:$sheet->setCellValue('D3', $engineer_db_info[0]['family_name']);
      foreach($exp_items_base as $export_item){
        $sheet->setCellValue($export_item['item_value'], $engineer_db_info[0][$export_item['item_name']]);  
      }

      /**
       経歴(career)情報をエクセルに出力する
       */
      //経歴情報の項目値を取得する
      $exp_items_career = m_export_item::CategoryEqual('career') -> get();

      $init_line_num = m_export_item::CategoryEqual('config') -> 
                              ItemNameEqual('init_line') -> get();

      //エクセル上の経歴(career)情報蘭の値を設定する
      for ($i=0; $i < count($engineer_db_info); ++$i){
        $actual_line_num = $init_line_num[0]['item_value']+$i; //エクセル上の出力行(line)数
           
        foreach ($exp_items_career as $exp_item){
          $exp_value = is_null($engineer_db_info[$i][$exp_item['item_name']])?'経歴No'.$i+1:$engineer_db_info[$i][$exp_item['item_name']];
          $sheet->setCellValue($exp_item['item_value'].$actual_line_num, $exp_value);
        }
      }

      /**
      *for ($i=0; $i < count($engineer_db_info); ++$i){

        $actual_line_num = $init_line_num+$i; //エクセル上の出力行数

        $sheet->setCellValue('C'.$actual_line_num, '経歴No'.$i+1);
        $sheet->setCellValue('D'.$actual_line_num, $engineer_db_info[$i]['pj_outline']);
        $sheet->setCellValue('E'.$actual_line_num, $engineer_db_info[$i]['role']);
        $sheet->setCellValue('F'.$actual_line_num, $engineer_db_info[$i]['task']);
        $sheet->setCellValue('G'.$actual_line_num, $engineer_db_info[$i]['pj_dev_env']);
        $sheet->setCellValue('H'.$actual_line_num, $engineer_db_info[$i]['period_from']);
        $sheet->setCellValue('I'.$actual_line_num, $engineer_db_info[$i]['period_to']);
      *}
      */

      return $spreadsheet;
    }

}
