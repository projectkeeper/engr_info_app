<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_dev_env_value extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_value',
        'owner',
        'status',
        'display_order',
        ];

    /**
    開発環境マスタ情報（基本情報、経歴情報）を取得する。
    */
    //画面表示項目のオーナー
    public function scopeOwnerEqual($query, $str)
    {
      return $query -> where('owner', $str);
    }

    //マスタデータのステータス
    public function scopeStatusEqual($query, $str)
    {
      return $query -> where('status', $str);
    }

    /**
    検索キーに一致する複数のマスター情報を取得する。
    */
    public function scopeMasterSearch($query, $params)
    {
      //画面項目名
      if (isset($params['item_name'])){
        $query->where('item_name','LIKE' ,'%'.$params['item_name'].'%');
      }

      //画面表示項目のオーナー
      if (isset($params['owner'])){
        $query->where('owner','LIKE','%'.$params['owner'].'%');
      }
    }
}
