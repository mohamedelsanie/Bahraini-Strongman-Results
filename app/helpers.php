<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

if(! function_exists('AdminName')){
    function AdminName(){
        return Auth::guard('admin')->user()->name;
    }
}

if(! function_exists('UserName')){
    function UserName(){
        return Auth::user()->name;
    }
}

if(! function_exists('AdminCan')){
    function AdminCan($permission){
        return auth()->guard('admin')->user()->can($permission);
    }
}

if(! function_exists('AdminId')){
    function AdminId(){
        return Auth::guard('admin')->user()->id;
    }
}

if(! function_exists('admin_paginate')){
    function admin_paginate(){
        $settings = Setting::checkSetting();
        return $settings->admin_paginate;
    }
}

if(! function_exists('getSetting')){
    function getSetting($val){
        $settings = Setting::checkSetting();
        return $settings->$val;
    }
}


if(! function_exists('activeMenu')){
    function activeMenu($uri = '') {
        $active = '';
        if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}

if(! function_exists('getCookie')){
    function getCookie($value){
        $var = Request::cookie($value);
        return $var;
    }
}
