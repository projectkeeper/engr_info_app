<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_export_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category',
        'item_name',
        'item_value',
        'status',
        'display_order',
        'created_at',
        'updated_at',
        ];

    /**
    出力項目情報（基本情報の項目、経歴情報の項目）を取得する。
    */
    public function scopeCategoryEqual($query, $str)
    {
      return $query -> where('item_category', $str);
    }

    public function scopeItemNameEqual($query, $str)
    {
      return $query -> where('item_name', $str);
    }

}
