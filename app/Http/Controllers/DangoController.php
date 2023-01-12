<?php

namespace App\Http\Controllers;

use App\Imports\DangoImport;
use App\Exports\DangoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

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
      return Excel::download(new DangoExport, 'dango.xlsx');
  }

}
