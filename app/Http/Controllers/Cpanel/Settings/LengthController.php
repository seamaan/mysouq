<?php

namespace App\Http\Controllers\cpanel\settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \App\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Classes\Btn;
use \App\Length;

class LengthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('mrole:lengths');

        resourceBreadcrumbs('length',function($length){
            return $length->name;
        });
    }
public function getDatatable()
    {
        $row=Length::all();
        return Datatables::of($row)
            ->editColumn('control', function ($model) {
                $all='';
                //$all .= Btn::view($model->id,'lengths','users/'.$model->id.'/edit') ;
                $all .= Btn::edit($model->id,'lengths/'.$model->id.'/edit') ;
                $all .= Btn::delete($model->id,$model->name,'cpanel/lengths/'.$model->id) ;
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
                $name .='<a href="'.url('cpanel/lengths/' . $model->id ).'">'.$model->name.'</a> ';
                $name .=$model->default==1?' ( '.trans('lang.default').' ) ':'';
                return $name;
            })

            ->rawColumns(['checkbox','control','name'])//render to Html
            ->make(true);
    }
    public function index()
    {
        return \Process::index('lengths');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Process::create('lengths');
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
            Length::where('default',1)->update(['default'=>0]);
        }
           $this->validate($request,[
            'translate' => [
                'name' => 'required',
                'unit_code' => 'required',
            ],
               'value' => 'required',

        ]); 

         return \Process::store(request(),'lengths',[
            'translate' => [
                 'name',
                 'unit_code',
             ],
             'value'=>request('value'),
             'default'=>request('default',0),
             ],cp.'lengths',function ($query){
            return redirect(cp.'lengths');

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
        return \Process::show('lengths',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit('lengths',$id);
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
            Length::where('default',1)->update(['default'=>0]);
        }
        $this->validate($request,[
            'translate' => [
                'name' => 'required',
                'unit_code' => 'required',
            ],
            'value' => 'required',

        ]);

        return \Process::update($request,$id,'lengths',[
          'translate' => [
                'name',
              'unit_code',
            ],
            'value'=>request('value'),
            'default'=>request('default',0),
        ],cp.'lengths',function ($query){
            return redirect(cp.'lengths');
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
         return  \Process::delete($request,$id,'lengths');
    }

    public function order(Request $request)
    {
        return \Process::order($request->data,'lengths',0);
    }

}
