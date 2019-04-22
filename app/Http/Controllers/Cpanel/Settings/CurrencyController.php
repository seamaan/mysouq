<?php

namespace App\Http\Controllers\Cpanel\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \App\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Classes\Btn;
use \App\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('mrole:currencies');

        resourceBreadcrumbs('currency',function($currency){
            return $currency->name;
        });
    }
public function getDatatable()
    {
        $row=Currency::all();
        return Datatables::of($row)
            ->editColumn('control', function ($model) {
                $all='';
                //$all .= Btn::view($model->id,'currencies','users/'.$model->id.'/edit') ;
                $all .= Btn::edit($model->id,'currencies/'.$model->id.'/edit') ;
                $all .= Btn::delete($model->id,$model->name,'cpanel/currencies/'.$model->id) ;
                return $all;
            })
            ->editColumn('checkbox', function ($model) {
                $chk='';
                 $chk .='<input form="delete_form" id="chkbox'.$model->id.'" class="css-checkbox chkbox" type="checkbox" name="delete[]" value="'.$model->id.'">';
                 $chk .='<label for="chkbox'.$model->id.'" name="checkbox2_lbl" class="css-label lite-red-check"></label>';
                return $chk;
            })
            ->editColumn('name', function ($model) {
                $name='<a href="'.url('cpanel/currencies/' . $model->id ).'">'.$model->name.'</a> ';
                return $name;
            })
            ->editColumn('currency_icon', function ($model) {
                $currency_icon='<i class="fa '.$model->currency_icon.'"></i>';
                return $currency_icon;
            })
            ->rawColumns(['checkbox','control','name','currency_icon'])//render to Html
            ->make(true);
    }
    public function index()
    {
        return \Process::index('currencies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Process::create('currencies');
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
            'currency_code' => 'required',

        ]); 

         return \Process::store(request(),'currencies',[
            'translate' => [
                 'name',
             ],
            'currency_code'=>request('currency_code'),
            'currency_icon'=>request('currency_icon'),
        ],cp.'currencies',function ($query){
            return redirect(cp.'currencies');

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
        return \Process::show('currencies',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit('currencies',$id);
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

                    //'content' => 'required',
                  ],
                'currency_code'=>'required',
            ]); 
                      
        return \Process::update($request,$id,'currencies',[
          'translate' => [
                'name',
            ],
            'currency_code'=>request('currency_code'),
            'currency_icon'=>request('currency_icon'),
            ],cp.'currencies',function ($query){
            return redirect(cp.'currencies');
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
         return  \Process::delete($request,$id,'currencies');
    }

    public function order(Request $request)
    {
        return \Process::order($request->data,'currencies',0);
    }

}
