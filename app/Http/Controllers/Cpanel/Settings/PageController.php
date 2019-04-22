<?php

namespace App\Http\Controllers\Cpanel\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
         $admin=auth()->guard('admin')->user();

          //dd($admin->roles);
         foreach ($admin->roles as $ro) {
            $rr[]=$ro->name;
            if($ro->name='pages'){
            
                foreach ($ro->permissions as $perm) {

                  $per[]=$perm->name;  

                }
            }
            
         }
       //  dd($per);

      //$prm=implode("','",$per);
        //dd(array_values($per));
        //$this->middleware('mrole:pages',['only'=>['index']]);//only admin can use this permission
         $this->middleware('mrole:pages');
        //$this->middleware('mrole:pages',['except'=>['index','show']]);

        resourceBreadcrumbs('page',function($page){
            return $page->name;
        });
    }


    public function index(Request $request)
    {
       return \Process::index('page');
    }
    public function getAnyData()
    {
        $pages = Page::all();
        return Datatables::of($pages)
            ->editColumn('control', function ($model) {
                $all = '<a href="' . url('cpanel/pages/' . $model->id . '/edit') . '" 
                class="btn btn-info btn-circle"><i class="fa fa-edit"></i></a> ';
                $all .= '<a href="' . url('cpanel/pages/' . $model->id . '/delete') . '" 
                class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></a> ';
                $all .= '<a href="' . url('cpanel/pages/' . $model->id . '/show') . '" 
                class="btn btn-success btn-circle"><i class="fa fa-eye"></i></a> ';
                return $all;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Process::create('page');
    }

    public function show($id)
    {
        return \Process::show('page',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit('page',$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(),[
            'name'=>'required',

        ]);

        return \Process::store(request(),'pages',[
            'name'=>request('name'),
            'content'=>request('content'),
        ],cp.'pages',function ($query){
            return redirect(cp.'pages');

        });
    }
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'name'=>'required',
        ]);
        return \Process::update($request,$id,'pages',[
            'name'=>request('name'),
            'content'=>request('content'),
        ],cp.'pages',function ($query){
            return redirect(cp.'pages');
        });
    }
    public function destroy(Request $request,$id=null)
    {
        return  \Process::delete($request,$id,'pages');

    }
    public function order(Request $request,$id=null)
    {
      dd('ddd');
        //return  \Process::delete($request,$id,'pages');

    }


}
