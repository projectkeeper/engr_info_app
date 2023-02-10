<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\t_eng_base;
use App\Models\m_information_item;
use Illuminate\Support\Facades\Log;

class TopScreenComposer {

  public function compose(View $view){

    //Queryを作成する
    $eng_data_opened = t_eng_base::engineerInfoAsPerStatus('2')->count();
    $eng_data_yet_opened = t_eng_base::engineerInfoAsPerStatus('1')->count();
    $eng_data_progress = t_eng_base::engineerInfoAsPerStatus('0')->count();

      $view->with('eng_data_opened', $eng_data_opened);
      $view->with('eng_data_yet_opened', $eng_data_yet_opened);
      $view->with('eng_data_progress', $eng_data_progress);

      //現在日付（YMD）を取得
      $today_ymd = date("Y-m-d");

    //Information Itemの取得
    $infomation_list = m_information_item::getValidInformationItem($today_ymd)->get();

    $view->with('infomation_list', $infomation_list);

  }
}
