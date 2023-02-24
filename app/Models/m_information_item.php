<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class m_information_item extends Model
{
    use HasFactory;

    const VALID_MSG_REQUIRED_TITLE = 'タイトルを、入力してください。知らんけど（笑）';
    const VALID_MSG_REQUIRED_TARGET = '対象者を、入力してくださいね。知らんけど（笑）';
    const VALID_MSG_REQUIRED_CONTENT = '情報内容を、入力してくださいね。知らんけど（笑）';
    const VALID_MSG_REQUIRED_FROM = '期限Fromを、入力してくださいね。知らんけど（笑）';
    const VALID_MSG_REQUIRED_TO = '期限Toを、入力してくださいね。知らんけど（笑）';
    const VALID_MSG_REQUIRED_DISPLAY_ORDER = '表示順を、入力してくださいね。知らんけど（笑）';

    protected $fillable = [
        'title',
        'target',
        'content',
        'from',
        'to',
        'display_order',
        'status',
        'created_at',
        'updated_at',
        ];

        /**
        有効な、お知らせ情報を取得する。
        */
        public function scopeGetValidInformationItem($query, $today_ymd)
        {
          //有効データ取得条件
          $query->where('status','0');

Log::debug("m_information_item->today_ymd: ".$today_ymd);

          //有効期限内のお知らせ情報データの取得条件
          $query -> where('from', '<=', $today_ymd)->where('to', '>=', $today_ymd);

          //表示順番の設定
          $query -> orderBy('display_order', 'asc');

          return $query;
        }
}
