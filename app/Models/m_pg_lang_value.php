<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_pg_lang_value extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_value',
        'owner',
        'status',
        'display_order',
        ];

    public function scopeOwnerEqual($query, $str)
    {
      return $query -> where('owner', $str);
    }

    public function scopeStatusEqual($query, $str)
    {
      return $query -> where('status', $str);
    }


}
