<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_eng_career extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'base_info_id',
        'career_info_id',
        'pj_outline',
        'role',
        'task',
        'dev_env',
        'period_from',
        'period_to'
        ];
}
