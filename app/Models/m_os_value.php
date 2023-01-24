<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_os_value extends Model
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
    １人分のエンジニア情報（基本情報、経歴情報）を取得する。
    */

    public function scopeOwnerEqual($query, $str)
    {
      return $query -> where('owner', $str);
    }

    public function scopeStatusEqual($query, $str)
    {
      return $query -> where('status', $str);
    }

}
