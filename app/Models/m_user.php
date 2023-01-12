<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_user extends Model
{
    use HasFactory;

public function scopeLoginIDEqual($query, $str)
{
  return $query -> where('login_id', $str);
}

public function scopeLoginPassEqual($query, $str)
{
  return $query -> where('login_pass', $str);
}

}
