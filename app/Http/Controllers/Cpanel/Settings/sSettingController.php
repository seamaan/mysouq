<?php

namespace App\Http\Controllers\Cpanel\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct()
    {          
        $this->middleware('mrole:settings');
        resourceBreadcrumbs('setting',function($setting){
            return $setting->name;
        });
    }
    public function lang($lang)
    {
        //dd($lang);
        \Cookie::queue(\Cookie::make('locale',$lang,43200));
        return back();
    }
    public function index()
    {
        return \Process::index('setting');
    }
    public function store()
    {
        $this->validate(request(),[
            'site_name'=>'required',
            'site_mail'=>'required',
            'maintenance'=>'required',
            'site_desc'=>'required',
            'keywords'=>'required',
        ]);
        return \Process::update(request(),1,'settings',[
            'site_name'=>request('site_name'),
            'site_mail'=>request('site_mail'),
            'maintenance'=>request('maintenance'),
            'facebook'=>request('facebook'),
            'twitter'=>request('twitter'),
            'site_desc'=>request('site_desc'),
            'keywords'=>request('keywords'),
        ],null,function (){
            return back();

        });
    }
}
