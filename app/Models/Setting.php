<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_url',
        'site_logo',
        'site_favicon',
        'site_status',
        'admin_paginate',
        'site_name',
        'site_slogan',
        'site_meta_description',
        'site_meta_keywords',
        'close_msg',
        'posts_per_page',
    ];
    public static function checkSetting(){
        $settings = Self::all();
        if (count($settings) < 1) {
            $data = [
                'site_name' => 'Sitename',
                'id' => 1,
                'site_status' => 'publish',
            ];
            Self::create($data);
        }
        return Self::first();
    }
}
