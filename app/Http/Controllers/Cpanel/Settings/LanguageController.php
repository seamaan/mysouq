<?php

namespace App\Http\Controllers\Cpanel\Settings;

use function Couchbase\basicDecoderV1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {


        $this->middleware('mrole:languages');
        resourceBreadcrumbs('language',function($lang){
            return $lang->name;
        });
    }
    public function index()
    {
        //copy_lang_folder('ar','sdd');
        //delete_lang_folder('sdd');
        //dd(app()->getLocale());
        return \Process::index('lang','cpanel.languages.index');//function index($tblname,$view=null,$compact=[],$callback=null)

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return \Process::create('lang','cpanel.languages.create');
        return \Process::create('languages');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin_id=Auth::guard('admin')->user()->id;
        $this->validate($request,[
            "name" => "required",
            "lang_code" => "required",
            "direction" => "required",
        ]);
        if($request->has('default'))
        {
            \App\Lang::where('default',1)->update(['default'=>0]);
        }
        return \Process::store($request,'lang',[
            'name'=>$request->name,
            'code'=>$request->lang_code,
            'direction'=>$request->direction,
            'default'=>request('default',0),
            'flag'=>$request->flag,
            'admin_id'=>$admin_id,

        ],cp.'languages',function ($query){
            //dd($query->lang_code);
            copy_lang_folder('ar',$query->lang_code);
            session()->flash('success',trans('lang.added_lang'));
            return redirect(cp.'languages');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit('lang',$id,'cpanel.languages.edit');

    }
    public function postTranslate(Request $request,$id)
    {
        //  dd(request()->all());
        $lang=\App\Lang::find($id);
        $filesArray=glob((base_path('resources/lang/'.$lang->code.'/*.php')));
        $data='';
        //dd($filesArray);
        foreach($filesArray as $index=>$file)
        {

            $data="<?php return [ ";
               foreach($request->{'content_value_'.$index} as $key=>$value )
                   {
                      $data.="'".$request->{'content_key_'.$index}{$key}."'=>'".$value."',";
                   }
            $data.="];";
            @file_put_contents($file,$data);
        }
        session()->flash('success',trans('lang.system_updated'));
        return back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            "name" => "required",
            "lang_code" => "required",
            "direction" => "required",
        ]);
        if($request->has('default'))
        {
            \App\Lang::where('default',1)->update(['default'=>0]);
        }
        return \Process::update($request,$id,'lang',[
            'name'=>$request->name,
            'code'=>$request->lang_code,
            'direction'=>$request->direction,
            'default'=>request('default',0),
            'flag'=>$request->flag,
        ],cp.'languages',function ($query){
            rename_lang_folder('ar',$query->code);
            session()->flash('success',trans('lang.language_update'));
            return redirect(cp.'languages');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if( is_null($id)&&!$request->has('delete') )
        {
            session()->flash('error',trans('lang.no_record_selected'));
            return back();
        }

        elseif ($request->has('delete'))
        {
            foreach ($request->input('delete') as $value)
            {
                $lang = \App\Lang::find($value);
                $directory=base_path('resources/lang/' . $lang->code);
                if($lang->default==1){
                    session()->flash('error',trans('lang.cant_delete_default'));
                }else{
                    \File::deleteDirectory($directory);
                    $lang->delete();
                    session()->flash('success',trans('lang.deleted',['var'=>trans(str_plural($lang->name))]));
                }

            }
        }
        elseif ($id != null) {
            $lang = \App\Lang::find($id);
            $directory=base_path('resources/lang/' . $lang->code);
            if($lang->default==1){
                session()->flash('error',trans('lang.cant_delete_default'));
            }else{
            \File::deleteDirectory($directory);
            $lang->delete();
            session()->flash('success',trans('lang.deleted',['var'=>trans(str_plural($lang->name))]));
            }

        }
              /*****/
        return back();
    }
}
