<?php

namespace App\Http\Controllers;

use App\Imports\DangoImport;
use App\Exports\DangoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing\Shadow;
use Illuminate\Support\Facades\Log;


class DangoController extends Controller
{
    public function dango(){
      return view('dango');
    }


  public function import(){
      Excel::import(new DangoImport, request()->file('file'));
      return back();
  }

  public function export(){

    self::kikakusho();
    return view('dango');

    //return Excel::download(new DangoExport, 'dango.xlsx');
  }


  public static function kikakusho(){
      #エクセルのテンプレートファイルのPathを指示
      $excel_file = storage_path('app/Excel_format/Template_EngineerCareer.xlsx');

      //エクセルオブジェクト設定と出力データの設定
      $spreadsheet = self::createBase($excel_file);

      #作成したエクセルファイルを、サーバ上の特定のPathに出力する。
      #一時保存
      //$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
      //$savepath = storage_path('app/excel_format/').'engineer_career_history.xlsx';
      //$savepath = 'C:/tmp/engineer_career_history.xlsx';
      #エクセルファイルの出力
      //$writer->save($savepath);

      //エクセルファイルを、ローカルPCにダウンロードする
      #エクセルファイル名を設定
      $filename='engineer_career_history_.xlsx';

      #エクセルファイルをダウンロードするためのWriterのインスタンスを生成
      $writer = new WriterXlsx($spreadsheet);

      //headerの設定
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="'. $filename .'"');

      #エクセルファイルをダウンロードする
      $writer->save('php://output');

//Log::debug('savepath: '.$savepath);
      return $filename;
    }

    /**
      エクセルテンプレートの読み込みと、出力値の設定
    */
    public static function createBase($excel_file){

    #エクセルのテンプレートファイルを取得
    $reader = new ReaderXlsx();
    $spreadsheet = $reader->load($excel_file);

    #エクセルのテンプレートファイル上の、アクティブシートオブジェクトの取得
    $sheet = $spreadsheet->getActiveSheet();

    #指定箇所に文字列を出力する
    $sheet->setCellValue('C2','佐々木秀太郎');
    $sheet->setCellValue('C3','ササキ シュウタロウ');

    return $spreadsheet;
  }
}
