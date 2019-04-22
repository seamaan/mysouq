<?php

namespace App\Http\Controllers\Cpanel\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \App\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Classes\Btn;
use \App\Measurementunit;

class MeasurementunitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('mrole:measurementunits');

        resourceBreadcrumbs('measurementunit',function($measurementunit){
            return $measurementunit->name;
        });
    }
public function getDatatable()
    {
        $row=Measurementunit::all();
        return Datatables::of($row)
            ->editColumn('control', function ($model) {
                $all='';
                //$all .= Btn::view($model->id,'measurementunits','users/'.$model->id.'/edit') ;
                $all .= Btn::edit($model->id,'measurementunits/'.$model->id.'/edit') ;
                $all .= Btn::delete($model->id,$model->name,'cpanel/measurementunits/'.$model->id) ;
                return $all;
            })
            ->editColumn('checkbox', function ($model) {
                $chk='';
                 $chk .='<input form="delete_form" id="chkbox'.$model->id.'" class="css-checkbox chkbox" type="checkbox" name="delete[]" value="'.$model->id.'">';
                 $chk .='<label for="chkbox'.$model->id.'" name="checkbox2_lbl" class="css-label lite-red-check"></label>';
                return $chk;
            })
            ->editColumn('name', function ($model) {
                $name='<a href="'.url('cpanel/measurementunits/' . $model->id ).'">'.$model->name.'</a> ';
                return $name;
            })
            ->rawColumns(['checkbox','control','name'])//render to Html
            ->make(true);
    }
    public function index()
    {
        return \Process::index('measurementunits');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Process::create('measurementunits');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $this->validate($request,[
            'translate' => [
                'name' => 'required',
            ],
            'unit_code' => 'required',

        ]); 

         return \Process::store(request(),'measurementunits',[
            'translate' => [
                 'name',
             ],
            'unit_code'=>request('unit_code'),
        ],cp.'measurementunits',function ($query){
            return redirect(cp.'measurementunits');

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
        return \Process::show('measurementunits',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit('measurementunits',$id);
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
                  'translate' => [
                      'name' => 'required',
                  ],
                     'unit_code'=>'required',
            ]); 
                      
        return \Process::update($request,$id,'measurementunits',[
          'translate' => [
                'name',
            ],
            'unit_code'=>request('unit_code'),
        ],cp.'measurementunits',function ($query){
            return redirect(cp.'measurementunits');
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
         return  \Process::delete($request,$id,'measurementunits');
    }

    public function order(Request $request)
    {
        return \Process::order($request->data,'measurementunits',0);
    }

}
