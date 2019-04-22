<?php

namespace App\Http\Controllers\cpanel\settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \App\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Classes\Btn;
use \App\Weight;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('mrole:weights');

        resourceBreadcrumbs('weight',function($weight){
            return $weight->name;
        });
    }
public function getDatatable()
    {
        $row=Weight::all();
        return Datatables::of($row)
            ->editColumn('control', function ($model) {
                $all='';
                //$all .= Btn::view($model->id,'weights','users/'.$model->id.'/edit') ;
                $all .= Btn::edit($model->id,'weights/'.$model->id.'/edit') ;
                $all .= Btn::delete($model->id,$model->name,'cpanel/weights/'.$model->id) ;
                return $all;
            })
            ->editColumn('checkbox', function ($model) {
                $chk='';
                 $chk .='<input form="delete_form" id="chkbox'.$model->id.'" class="css-checkbox chkbox" type="checkbox" name="delete[]" value="'.$model->id.'">';
                 $chk .='<label for="chkbox'.$model->id.'" name="checkbox2_lbl" class="css-label lite-red-check"></label>';
                return $chk;
            })
            ->editColumn('name', function ($model) {
                $name='';
                $name .='<a href="'.url('cpanel/weights/' . $model->id ).'">'.$model->name.'</a> ';
                $name .=$model->default==1?' ( '.trans('lang.default').' ) ':'';
                return $name;
            })
            ->rawColumns(['checkbox','control','name'])//render to Html
            ->make(true);
    }
    public function index()
    {
        return \Process::index('weights');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Process::create('weights');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('default'))
        {
            Weight::where('default',1)->update(['default'=>0]);
        }
           $this->validate($request,[
            'translate' => [
                'name' => 'required',
                'unit_code' => 'required',
            ],
            'value' => 'required',

        ]); 

         return \Process::store(request(),'weights',[
            'translate' => [
                 'name',
                 'unit_code',
             ],
            'value'=>request('value'),
             'default'=>request('default',0),
        ],cp.'weights',function ($query){
            return redirect(cp.'weights');

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
        return \Process::show('weights',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit('weights',$id);
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
        if($request->has('default'))
        {
            Weight::where('default',1)->update(['default'=>0]);
        }
            $this->validate($request,[
                  'translate' => [
                      'name' => 'required',
                      'unit_code' => 'required',
                  ],
                     //'name'=>'required',
            ]); 
                      
        return \Process::update($request,$id,'weights',[
          'translate' => [
                'name',
                'unit_code',
            ],
            'value'=>request('value'),
            'default'=>request('default',0),
            ],cp.'weights',function ($query){
            return redirect(cp.'weights');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
         return  \Process::delete($request,$id,'weights');
    }

    public function order(Request $request)
    {
        return \Process::order($request->data,'weights',0);
    }

}
