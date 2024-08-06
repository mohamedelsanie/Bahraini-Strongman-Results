<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'num',
        'wieght',
        'team',
        'category',
        'image',
        'final_result',
    ];

    public function results(){
        return $this->hasMany(Result::class,'player_id','id')->orderBy('result');
    }
}
