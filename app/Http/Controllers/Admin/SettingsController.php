<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:setting-edit,admin', ['only' => ['form','store']]);
    }

    public function form()
    {
        $setting = Setting::get()->first();
//        dd($setting);
        return view('admin.settings.edit',['setting'=>$setting]);
    }

    public function store(Request $request)
    {
        $data = [
            'site_url'    => 'required',
        ];


        $validator = Validator::make($request->all(), $data);
        if($validator->fails()){
//            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }

//        dd($request->all());
        $setting = Setting::find(1);
//
//        $setting->site_url = $request->site_url;
//        $setting->ar->site_name = $request->ar['site_name'];
//        $setting->en->site_name = $request->en['site_name'];
////
//        $setting->save();

        $setting->update($request->except( '_token'));

        return redirect()->route('admin.settings')->with([
            'message' => trans('admin/setting.saved'),
            'alert_type' => 'success'
        ]);

    }
}
