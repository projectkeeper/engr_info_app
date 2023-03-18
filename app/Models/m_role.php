<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_role extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_value',
        'status',
        'display_order',
        ];

    //マスタデータのステータス
    public function scopeStatusEqual($query, $str)
    {
      return $query -> where('status', $str);
    }
}
