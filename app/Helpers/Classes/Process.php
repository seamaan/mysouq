<?php
namespace App\Helpers\Classes;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
class Process{
    public static function show($tblname,$id,$view=null,$compact=[])
    {
        if(is_null($view))
        {
            $view= 'cpanel.'.strtolower(str_plural($tblname)).'.show';
        }

        $model='\App\\'.ucfirst(str_singular($tblname));
        $row=$model::where('id',$id);



        if($row->exists())
        {
            if(count($compact)== 0)
            {
                $compact=[strtolower(str_singular($tblname))=>$row->first()];
            }
            return view($view,$compact);
        }else{
            return view('cpanel.inc.error404');
        }
    }
    public static function edit($tblname,$id,$view=null,$compact=[])
    {
        if(is_null($view))
        {
            $view= 'cpanel.'.strtolower(str_plural($tblname)).'.edit';
        }
        $model='\App\\'.ucfirst(str_singular($tblname));
        $row=$model::where('id',$id);
        if($row->exists())
        {
            if(count($compact)== 0)
            {
                $compact=[strtolower(str_singular($tblname))=>$row->first()];
            }
            return view($view,$compact);
        }else{
            return abort(404,'No Page');
        }
    }
    public static function index($tblname,$view=null,$compact=[],$callback=null)
    {
        if(is_null($view))
        {
            $view= 'cpanel.'.strtolower(str_plural($tblname)).'.index';
        }


        $model='\App\\'.ucfirst(str_singular($tblname));
        $row=$model::orderBy('id','desc')->get();
        if (is_callable(($callback)))
        {
            $row=call_user_func_array($callback,[$row]);
        }
            if(count($compact)== 0)
            {
                $compact=[strtolower(str_plural($tblname))=>$row];
            }
            return view($view,$compact);

    }
    public static function create($tblname,$view=null,$compact=[])
    {
        if(is_null($view))
        {
            $view= 'cpanel.'.strtolower(str_plural($tblname)).'.create';
            return view($view,$compact);
        }else{
            return abort(404,'No Page');
        }

    }
    public static function store2(Request $request,$tblname,$tbldata=[],$redirect=null,$callback=null)
    {
        /*$validate=isset($tbldata['validate'])? $tbldata['validate'] :[];
        \Validator::make($request->all(),$validate);/***/

        $model='\App\\'.ucfirst(str_singular($tblname));
        $row=new $model;
        foreach (array_except($tbldata,'validate') as $key=>$value){
            $row->{$key}=$value;
        }
        $row->save();
         \Files::upload($request,str_singular($tblname),$row->id);
        session()->flash('success',trans('lang.added',['var'=>trans('lang.'.str_singular($tblname))]));

        if(!is_null($callback) && is_callable($callback))
        {
            return call_user_func_array($callback,[$row,$row->id]);
        }
        if(is_null($redirect))
        {
            return back();
        }else{
            return redirect($redirect);
        }
    }
    public static function store(Request $request ,$name,$data=[],$redirect=null,$calback=null)
    {
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        if (isset($data['translate']))
        {
            //dd($data['translate']);
            //$field=name,content;
            foreach ($data['translate'] as $k => $field)
            {
                foreach (\App\Lang::all() as $lang)
                {
                    if (is_string($k))
                    {
                        $data['lang'][$k.'-'.$lang->id] = $field;
                    }elseif(is_numeric($k))
                    {
                        $transField = $field.$lang->id;
                        //$transField = name1;
                        //$transField = name2;
                        $data['lang'][$field.'-'.$lang->id] = $request->{$transField};
                        //$data['lang'][name-1] = $request->{name1};
                        //$data['lang'][name-2] = $request->{name2};
                    }
                }
            }
        }
        $create = new $model;
        $currentLang = \App\Lang::where('code',app()->getLocale())->first();
        if (isset($data['translate']))
        {
            foreach ($data['translate'] as $k => $trans)
            {
                if (is_string($k))
                {
                    $data[$k] = $trans;
                }elseif(is_numeric($k))
                {
                    //$data['name']=$request->{name1}
                    $data[$trans] = $request->{$trans.$currentLang->id};
                }
            }
        }
        foreach (array_except($data, ['translate','lang','files']) as $key => $value)
        {
            $create->{$key} = $value;
        }
        $create->save();
        if (isset($data['lang']))
        {
            foreach ($data['lang'] as $key => $value)
            {
                $colum = explode('-', $key)[0];//Break a string into an array:
                //$colum = explode('-', $key)[0]//name;
                $lang = explode('-', $key)[1];//1
                // updateLang($lang,$extends,$parent,$colum,$trans)
                updateLang($lang,$name,$create->id,$colum,$value);
            }
        }
        $id = $model::all()->last()->id;
         \Files::upload($request,str_singular($name),$id);
        session()->flash('success',trans('lang.added',['var'=>trans('lang.'.$name)]));
        if (is_callable($calback))
        {
            call_user_func_array($calback,[$request,$id]);
        }
        if (is_null($redirect))
        {
            return back();
        }else
        {
            return redirect($redirect);
        }
    }
     public static function slidestore(Request $request ,$name,$data=[],$redirect=null,$calback=null)
    {
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        if (isset($data['translate']))
        {
            //dd($data['translate']);
            foreach ($data['translate'] as $k => $field)
            {
                foreach (\App\Lang::all() as $lang)
                {
                    if (is_string($k))
                    {
                        $data['lang'][$k.'-'.$lang->id] = $field;
                    }elseif(is_numeric($k))
                    {
                        $transField = $field.$lang->id;
                        $data['lang'][$field.'-'.$lang->id] = $request->{$transField};
                    }
                }
            }
        }
        $create = new $model;
        $currentLang = \App\Lang::where('code',app()->getLocale())->first();
        if (isset($data['translate']))
        {
            foreach ($data['translate'] as $k => $trans)
            {
                if (is_string($k))
                {
                    $data[$k] = $trans;
                }elseif(is_numeric($k))
                {
                    $data[$trans] = $request->{$trans.$currentLang->id};
                }
            }
        }
        foreach (array_except($data, ['translate','lang','files']) as $key => $value)
        {
            $create->{$key} = $value;
        }
        $create->save();
        if (isset($data['lang']))
        {
            foreach ($data['lang'] as $key => $value)
            {
                $colum = explode('-', $key)[0];
                $lang = explode('-', $key)[1];
                updateLang($lang,$name,$create->id,$colum,$value);
            }
        }
        $id = $model::all()->last()->id;        
        session()->flash('success',trans('lang.added',['var'=>trans('lang.'.$name)]));
        if (is_callable($calback))
        {
            call_user_func_array($calback,[$request,$id]);
        }
        if (is_null($redirect))
        {
            return back();
        }else
        {
            return redirect($redirect);
        }
    }
    public static function slideupdate(Request $request,$id,$name,$data=[],$redirect=null,$calback=null)
    {

        if (isset($data['translate']))
        {
            foreach ($data['translate'] as $k => $field)
            {
                foreach (\App\Lang::all() as $lang)
                {
                    if (is_string($k))
                    {
                        $data['lang'][$k.'-'.$lang->id] = $field;
                    }elseif(is_numeric($k))
                    {
                        $transField = $field.$lang->id;
                        $data['lang'][$field.'-'.$lang->id] = $request->{$transField};
                    }
                }
            }
        }
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        $create = $model::find($id);
        $currentLang = \App\Lang::where('code',app()->getLocale())->first();
        if (isset($data['translate']))
        {
            foreach ($data['translate'] as $k => $trans)
            {
                if (is_string($k))
                {
                    $data[$k] = $trans;
                }elseif(is_numeric($k))
                {
                    $data[$trans] = $request->{$trans.$currentLang->id};
                }
            }
        }
        foreach (array_except($data, ['translate','lang','files']) as $key => $value)
        {
            $create->{$key} = $value;
        }
        $create->save();
        if (isset($data['lang']))
        {
            foreach ($data['lang'] as $key => $value)
            {
                $colum = explode('-', $key)[0];
                $lang = explode('-', $key)[1];
                updateLang($lang,$name,$create->id,$colum,$value);
            }
        }
//        if ( count($request->file())> 0 && !is_null(current($request->file())[0]) )
//        {
//            \Files::delete(str_singular($name),$id);
//        }
//        if(!empty(request('filepath'))){
//            \Files::delete(str_singular($name),$id);
//        }
//
//        \Files::upload($request,str_singular($name),$id);

        session()->flash('success',trans('lang.updated',['var'=>trans('lang.'.$name)]));
        if (is_callable($calback))
        {
            call_user_func_array($calback,[$request,$id]);
        }



        if (is_null($redirect))
        {
            return back();
        }else
        {
            return redirect($redirect);
        }
    }

    public static function updateold(Request $request,$id,$tblname,$tbldata=[],$redirect=null,$callback=null)
    {

        $model='\App\\'.ucfirst(str_singular($tblname));
        $row=$model::find($id);


        foreach ($tbldata as $key=>$value){
            $row->{$key}=$value;
        }
        $row->save();
        if ( count($request->file())> 0 && !is_null(current($request->file())[0]) )
        {
             \Files::delete(str_singular($tblname),$id);
        }

         \Files::upload($request,str_singular($tblname),$id);
        session()->flash('success',trans('lang.updated',['var'=>trans('lang.'.str_singular($tblname))]));

        if(!is_null($callback) && is_callable($callback))
        {
            return call_user_func_array($callback,[$row,$row->id]);
        }
        if(is_null($redirect))
        {
            return back();
        }else{
            return redirect($redirect);
        }
    }
    public static function update(Request $request,$id,$name,$data=[],$redirect=null,$calback=null)
    {

        if (isset($data['translate']))
        {
            foreach ($data['translate'] as $k => $field)
            {
                foreach (\App\Lang::all() as $lang)
                {
                    if (is_string($k))
                    {
                        $data['lang'][$k.'-'.$lang->id] = $field;
                    }elseif(is_numeric($k))
                    {
                        $transField = $field.$lang->id;
                        $data['lang'][$field.'-'.$lang->id] = $request->{$transField};
                    }
                }
            }
        }
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        $create = $model::find($id);
        $currentLang = \App\Lang::where('code',app()->getLocale())->first();
        if (isset($data['translate']))
        {
            foreach ($data['translate'] as $k => $trans)
            {
                if (is_string($k))
                {
                    $data[$k] = $trans;
                }elseif(is_numeric($k))
                {
                    $data[$trans] = $request->{$trans.$currentLang->id};
                }
            }
        }
        foreach (array_except($data, ['translate','lang','files']) as $key => $value)
        {
            $create->{$key} = $value;
        }
        $create->save();
        if (isset($data['lang']))
        {
            foreach ($data['lang'] as $key => $value)
            {
                $colum = explode('-', $key)[0];
                $lang = explode('-', $key)[1];
                updateLang($lang,$name,$create->id,$colum,$value);
            }
        }
//        if ( count($request->file())> 0 && !is_null(current($request->file())[0]) )
//        {
//            \Files::delete(str_singular($name),$id);
//        }
        if(!empty(request('filepath'))){
            \Files::delete(str_singular($name),$id);
        }

        \Files::upload($request,str_singular($name),$id);

        session()->flash('success',trans('lang.updated',['var'=>trans('lang.'.$name)]));
        if (is_callable($calback))
        {
            call_user_func_array($calback,[$request,$id]);
        }



        if (is_null($redirect))
        {
            return back();
        }else
        {
            return redirect($redirect);
        }
    }

    /**************************/
     public static function destroy(Request $request,$id=null,$tblname,$redirect=null,$callback=null)
    {
        $model='\App\\'.ucfirst(str_singular($tblname));
        $row=$model::find($id);
        session()->flash('success',trans('lang.deleted',['var'=>trans('lang.'.str_singular($tblname))]));


        if(!is_null($callback) && is_callable($callback))
        {
            return call_user_func_array($callback,[$row,$row->id]);
        }
        if ($request->has('delete'))
        {
            foreach ($request->delete as $id) {
               \Files::delete(str_singular($tblname),$id);
                $model::find($id)->delete();
            }
        }
        if(!is_null($id))
        {
            \Files::delete(str_singular($tblname),$id);
            $model::find($id)->delete();
        }
    

    
        if(is_null($redirect))
        {
            return back();
        }else{
            return redirect($redirect);
        }
    }
    /********** Delete With Parent ******/
     public static function DeleteParent($id,$tblname){
         $model='\App\\'.str_singular(ucfirst($tblname));
         $compact=str_singular(strtolower($tblname));
         $parentrow = $model::find($id);

         $getparent=$model::where('parent_id',$id);
         foreach ($getparent->get() as $parent){
             $check= $model::find($parent->id);
             if($check->parent_id > 0 ){
                self::DeleteParent($check->id,$tblname);
              }
           $check->delete();
            deleteLang($tblname,$check->id);

            \Files::delete(str_singular($tblname),$check->id);
         }

    }
     public static function deletewithparent(Request $request,$id=null,$tblname,$callback=null)
    {
        $model='\App\\'.str_singular(ucfirst($tblname));
        $compact=str_singular(strtolower($tblname));
        if( is_null($id)&&!$request->has('delete') )
        {
            session()->flash('error',trans('lang.no_record_selected'));
            return back();
        }
        elseif ($request->has('delete'))
        {
            foreach ($request->input('delete') as $value)
            {
               $rows = $model::where('id',$value)->get();
                foreach ($rows as $row){


                   if (is_callable($callback))
                    {
                        call_user_func_array($callback,[$row,$id,$tblname]);
                    }/****/
                  $getparent=$model::where('parent_id','=',$value)->get();
                    if(count($getparent)>0){
                        self::DeleteParent($value,$tblname);
                    }

            $row->delete();
            deleteLang($tblname,$row->id);
            \Files::delete(str_singular($tblname),$value);
                    /****/
                }
            }
            session()->flash('success',trans('lang.deleted',['var'=>trans('lang.'.str_plural(strtolower($tblname)))]));
        }
        elseif ($id != null)
        {

           $row = $model::find($id);

            if (is_callable($callback))
            {
                call_user_func_array($callback,[$row,$id]);
            }/***/
            $getparent=$model::where('parent_id','=',$id)->get();
            if(count($getparent) >0){
                self::DeleteParent($id,$tblname);
            }
                $row->delete();
                deleteLang($tblname,$id);
                \Files::delete(str_singular($tblname), $id);


            session()->flash('success',trans('lang.deleted',['var'=>$row->name ]));
        }
      return back();
    }
    /*******************************/
     public static function delete(Request $request,$id=null,$tblname,$callback=null)
    {
        $model='\App\\'.str_singular(ucfirst($tblname));
        $compact=str_singular(strtolower($tblname));
        if( is_null($id)&&!$request->has('delete') )
        {
            session()->flash('error',trans('lang.no_record_selected'));
            return back();
        }
        elseif ($request->has('delete'))
        {
            foreach ($request->input('delete') as $value)
            {
                $row = $model::find($value);
                if (is_callable($callback))
                {
                    call_user_func_array($callback,[$row,$id,$tblname]);
                }/****/
                $row->delete();
                deleteLang($tblname,$value);
                \Files::delete(str_singular($tblname),$value);

            }
            session()->flash('success',trans('lang.deleted',['var'=>trans('lang.'.str_plural(strtolower($tblname)))]));
        }
        elseif ($id != null)
        {
            $row = $model::find($id);
            if (is_callable($callback))
            {
                call_user_func_array($callback,[$row,$id]);
            }/***/
            $row->delete();
            deleteLang($tblname,$id);
            \Files::delete(str_singular($tblname), $id);
            session()->flash('success',trans('lang.deleted',['var'=>$row->name]));

        }
        return back();
    }

    public static function order($req,$name,$parent=0)
    {
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        foreach ($req as $key => $value)
        {
            $row = $model::find($value['id']);
            $row->parent_id = $parent;
            $row->order = $key;
            $row->save();
            if (!empty($value['children']) && is_array($value['children']))
            {
                self::order($value['children'],$name,$value['id']);
            }
        }
    }
    public static function orderHtml($name,$parentName,$parent = 0,$position=null)
    {
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        $rows = $model::where($parentName,$parent)->orderBy('order','asc')->get();
        if (!is_null($position))
        {
            $rows = $model::where($parentName,$parent)->where('position',$position)->orderBy('order','asc')->get();

        }
        return view('helpers.order',compact('rows','name','parentName','parent'))->render();
    }
    public static function megamenu($name,$parentName,$parent = 0,$position=null)
    {
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        $rows = $model::where($parentName,$parent)->orderBy('order','asc')->get();
        if (!is_null($position))
        {
            $rows = $model::where($parentName,$parent)->where('position',$position)->orderBy('order','asc')->get();

        }
        return view('site.menu',compact('rows','name','parentName','parent'))->render();
    }

    public static function mainOrderHtml($name,$parentName,$parent = 0,$position=null)
    {
        $model = '\App\\'.ucfirst(str_singular(camel_case($name)));
        $rows = $model::where($parentName,$parent)->orderBy('order','asc')->get();
        if (!is_null($position))
        {
            $rows = $model::where($parentName,$parent)->where('position',$position)->orderBy('order','asc')->get();
        }
        return view('Helper::main_order',compact('rows','name','parentName','parent','position'))->render();
    }


}