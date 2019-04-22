<?php

namespace App\Http\Controllers\Cpanel\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct()
    {


//        $this->middleware('mrole:settings');
//        resourceBreadcrumbs('setting',function($setting){
//            return $setting->name;
//        });
    }
    public function lang($lang)
    {
        //dd($lang);
        \Cookie::queue(\Cookie::make('locale',$lang,43200));
        return back();

    }
    public function index()
    {
        //updateLanguage(1,'setting',2,'site_name','E-commerce');
        //dd(app()->getLocale());
        return \Process::index('setting');
    }
    public function store(Request $request)
    {
        //dd($request->file());
        $this->validate(request(),[
            'site_name'=>'required',
            'site_mail'=>'required',
            'maintenance'=>'required',
            'site_desc'=>'required',
            'keywords'=>'required',
            'money_code'=>'required',
        ]);
        return \Process::update(request(),1,'settings',[
            'site_name'=>request('site_name'),
            'site_mail'=>request('site_mail'),
            'money_code'=>request('money_code'),
            'paymax'=>request('paymax'),
            'maintenance'=>request('maintenance'),
            'translate' => [
                'message_maintenance',
            ],
            //'message_maintenance'=>request('message_maintenance'),
            'facebook'=>request('facebook'),
            'twitter'=>request('twitter'),
            'site_desc'=>request('site_desc'),
            'keywords'=>request('keywords'),
        ],null,function (){
            return back();

        });
    }
}
