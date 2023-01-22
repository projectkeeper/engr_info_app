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
    //
    public function export_career_history(){
      #エクセルのテンプレートファイルのPathを指示
      $excel_file = storage_path('app/Excel_format/Template_EngineerCareer.xlsx');

        //画面入力値を、全て取得する
        $params = $request->input(); //画面入力値
        unset($params['_token']); //_tokenに紐づく値を削除する。

        //Queryを作成する -> エンジニア情報（1人分）を取得する
        $engineer_db_info = t_eng_base::getIndEngineerInfo($params)->get();

      //エクセルオブジェクト設定と出力データの設定
      $spreadsheet = self::set_export_data($excel_file, $engineer_db_info);

      //エクセルファイルを、ローカルPCにダウンロードする
      #エクセルファイル名を設定
      $filename='engineer_career_history_'.$engineer_db_info['first_name'].'.xlsx';

      #エクセルファイルをダウンロードするためのWriterのインスタンスを生成
      $writer = new WriterXlsx($spreadsheet);

      //headerの設定
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="'. $filename .'"');

      #エクセルファイルをダウンロードする
      $writer->save('php://output');
//Log::debug('savepath: '.$savepath);

      #Viewに連携するデータを設定
      $data = [
        'filename' => $filename, 'engineer_db_info' => $engineer_db_info
      ];

      return view('layout_section.layout_section_engineer.section_export_career_complete', $data);
    }

      /**
        エクセルテンプレートの読み込みと、出力値の設定
      */
      public static function set_export_data($excel_file,$engineer_db_info){

      #エクセルのテンプレートファイルを取得
      $reader = new ReaderXlsx();
      $spreadsheet = $reader->load($excel_file);

      #エクセルのテンプレートファイル上の、アクティブシートオブジェクトの取得
      $sheet = $spreadsheet->getActiveSheet();

      #指定箇所に文字列を出力する
      $sheet->setCellValue('C2','佐々木秀太郎');
      $sheet->setCellValue('C3','ササキ シュウタロウ');
      $sheet->setCellValue('C4', $engineer_db_info['faimily_name']);

      return $spreadsheet;
    }

}
