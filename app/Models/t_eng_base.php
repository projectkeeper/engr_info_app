<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class t_eng_base extends Model
{
    use HasFactory;

    const VALID_MSG_REQUIRED_FAMILY_NAME = '名前（姓）を、入力してください。知らんけど（笑）';
    const VALID_MSG_REQUIRED_FIRST_NAME = '名前（名）を、入力してくださいね。知らんけど（笑）';

    /// 主キーカラム名を指定
    protected $primaryKey = ['email','base_info_id'];

    // increment無効化
    public $incrementing = false;

    protected $fillable = [
        'family_name',
        'first_name',
        'family_name_kana',
        'first_name_kana',
        'certificates',
        'exprience_periods',
        'station_nearby',
        'OS',
        'PG_Lang',
        'dev_env',
        'data_status',
        'email',
        'base_info_id'];

    /**
    検索キーに一致する複数のエンジニア情報（基本情報、経歴情報）を取得する。
    */
    public function scopeEngineerSearch($query, $params)
    {

      $query->Join('t_eng_careers', 't_eng_bases.base_info_id', '=', 't_eng_careers.base_info_id')
                 ->select('*');

      /*
      エンジニア基本情報の検索キー
      */


      //氏名（名）
      if (isset($params['first_name'])){
        //$query->where(function ($query) use ($params) {
        $query->where('first_name', $params['first_name']);
        //});
      }

      //氏名（姓）
      if (isset($params['family_name'])){
        $query->where('family_name', $params['family_name']);
      }

      //カナ名（名）
      if (isset($params['first_name_kana'])){
        //$query->where(function ($query) use ($params) {
        $query->where('first_name_kana', $params['first_name_kana']);
        //});
      }

      //カナ名（姓）
      if (isset($params['family_name_kana'])){
        $query->where('family_name_kana', $params['family_name_kana']);
      }

      //資格
      if (isset($params['certificates'])){
        $query->where('certificates', $params['certificates']);
      }

      //経験年数
      if (isset($params['exprience_periods'])){
        $query->where('exprience_periods', $params['exprience_periods']);
      }

      //最寄り駅
      if (isset($params['station_nearby'])){
        $query->where('station_nearby', $params['station_nearby']);
      }

//Log::debug('OS');
//Log::debug($params['OS']);

      //データステータス
      if (isset($params['status'])){

        $status = $params['status'];

        //変数が配列かどうか判断
        if(is_array($params['status'])) { //変数が配列の場合
          for($i=0; $i<count($params['status']); ++$i){
            if($i==0){
              $query->where('t_eng_bases.data_status', $status[$i] ); // Andのlike句

            }else{
              $query->orWhere('t_eng_bases.data_status', $status[$i] ); // Orのlike句
            }
          }

        }else{  //変数が配列でない場合
              $query->where('t_eng_bases.data_status', $status );
        }
      }

      //OS
      if (isset($params['OS'])){

        $OS = $params['OS'];

        for($i=0; $i<count($params['OS']); ++$i){
          if($i==0){
            $query->where('OS', 'LIKE', '%'.$OS[$i].'%' ); // Andのlike句
          }else{
            $query->orWhere('OS', 'LIKE', '%'.$OS[$i].'%' ); // Orのlike句
          }
        }
      }

      //プログラミング言語
      if (isset($params['PG_Lang'])){
        $PG_Lang = $params['PG_Lang'];

        for($i=0; $i<count($params['PG_Lang']); ++$i){
          if($i==0){
            $query->where('PG_Lang', 'LIKE', '%'.$PG_Lang[$i].'%' ); // Andのlike句
          }else{
            $query->orWhere('PG_Lang', 'LIKE', '%'.$PG_Lang[$i].'%' ); // Orのlike句
          }
        }
      }

      //サーバ・クラウド
      if (isset($params['dev_env'])){

        $dev_env = $params['dev_env'];

        for($i=0; $i<count($params['dev_env']); ++$i){
          if($i==0){
            $query->where('dev_env', 'LIKE', '%'.$dev_env[$i].'%' ); // Andのlike句
          }else{
            $query->orWhere('dev_env', 'LIKE', '%'.$dev_env[$i].'%' ); // Orのlike句
          }
        }
      }

      /*
      エンジニア経歴情報の検索キー
      */
      //プロジェクト概要
      if (isset($params['pj_outline'])){
        $query->where('pj_outline','LIKE', '%'.$params['pj_outline'].'%');
      }

      //プロジェクト概要
      if (isset($params['task'])){
        $query->where('task', 'LIKE', '%'.$params['task'].'%');
      }

      //プロジェクト概要
      if (isset($params['role'])){
        $query->where('role', 'LIKE', '%'.$params['role'].'%');
      }

      //開発環境
      if (isset($params['pj_dev_env'])){
        $query->where('pj_dev_env', 'LIKE', '%'.$params['pj_dev_env'].'%');
      }

      //期間(from)
      if (isset($params['period_from'])){
        $query->where('period_from', $params['period_from']);
      }

      //期間(to)
      if (isset($params['period_to'])){
        $query->where('period_to', $params['period_to']);
      }

//dd($query->toSql(), $query->getBindings());
      return $query;
    }

    /**
    １人分のエンジニア情報（基本情報、経歴情報）を取得する。
    */

    public function scopeGetIndEngineerInfo($query, $params)
    {

      $query->Join('t_eng_careers', 't_eng_bases.base_info_id', '=', 't_eng_careers.base_info_id')
                 ->select('*');

       //エンジニアの基本情報ID
       if (isset($params['email'])){
         $query->where('t_eng_bases.email', $params['email']);
       }

      //エンジニアの基本情報ID
      if (isset($params['base_info_id'])){
        $query->where('t_eng_bases.base_info_id', $params['base_info_id']);
      }

      return $query;
    }

    /**
    ステータスごとの基本情報を取得する。
    */
    public function scopeEngineerInfoAsPerStatus($query, $data_status)
    {
      $query->where('data_status', $data_status);
    }

/*
    public function eng_career()
    {
      //結合（従テーブル）先のmodel path/name,foreign_key(外部キーのカラム名), local_key(ローカルキーのカラム名)
      return $this->hasMany('\App\Models\t_eng_career','base_info_id','base_info_id');
    }
*/

}
