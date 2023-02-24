<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Illuminate\Support\Facades\Log;
use App\Models\t_eng_base;

class DataExportController extends Controller
{
    /*
    * 経歴情報を作成し、エクセルに出力する
    */
    public function export_career_history(Request $request){
      
      #エクセルのテンプレートファイルのPathを指示
      $excel_file = storage_path('app/Excel_format/Template_EngineerCareer.xlsx');

      //画面入力値を、全て取得する
      $params = $request->input(); //画面入力値
      unset($params['_token']); //_tokenに紐づく値を削除する。

      //mail addr(user id)を取得する。
      $params['email'] = $request -> session() -> get('email');

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
       * エクセルテンプレートの読み込みと、出力値の設定
      */
      public static function set_export_data($excel_file,$engineer_db_info){

      #エクセルのテンプレートファイルを取得
      $reader = new ReaderXlsx();
      $spreadsheet = $reader->load($excel_file);

      #エクセルのテンプレートファイル上の、アクティブシートオブジェクトの取得
      $sheet = $spreadsheet->getActiveSheet();

      #指定箇所に文字列を出力する
      $sheet->setCellValue('D3', $engineer_db_info[0]['family_name'].$engineer_db_info[0]['first_name']);
      $sheet->setCellValue('D4', $engineer_db_info[0]['family_name_kana'].$engineer_db_info[0]['first_name_kana']);
      $sheet->setCellValue('D5', $engineer_db_info[0]['certificates']);
      $sheet->setCellValue('D6', $engineer_db_info[0]['exprience_periods']);
      $sheet->setCellValue('D7', $engineer_db_info[0]['station_nearby']);
      $sheet->setCellValue('D8', $engineer_db_info[0]['OS']);
      $sheet->setCellValue('D9', $engineer_db_info[0]['dev_env']);
      $sheet->setCellValue('D10', $engineer_db_info[0]['PG_Lang']);

      $init_line_num = "14";

      for ($i=0; $i < count($engineer_db_info); ++$i){

        $actual_line_num = $init_line_num+$i; //エクセル上の出力行数

        $sheet->setCellValue('C'.$actual_line_num, '経歴No'.$i+1);
        $sheet->setCellValue('D'.$actual_line_num, $engineer_db_info[$i]['pj_outline']);
        $sheet->setCellValue('E'.$actual_line_num, $engineer_db_info[$i]['role']);
        $sheet->setCellValue('F'.$actual_line_num, $engineer_db_info[$i]['task']);
        $sheet->setCellValue('G'.$actual_line_num, $engineer_db_info[$i]['pj_dev_env']);
        $sheet->setCellValue('H'.$actual_line_num, $engineer_db_info[$i]['period_from']);
        $sheet->setCellValue('I'.$actual_line_num, $engineer_db_info[$i]['period_to']);
      }

      return $spreadsheet;
    }

}
