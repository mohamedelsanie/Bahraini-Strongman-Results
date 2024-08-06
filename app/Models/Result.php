<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'category',
        'game',
        'distance',
        'time',
        'result',
    ];

    public function players(){
        return $this->hasOne(Player::class,'id','player_id');
    }
}
