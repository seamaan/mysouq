<?php

namespace App\Http\Controllers\Cpanel\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cpanelbar;

class CpanelBarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Process::index('cpanelbars');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cpanelbars = Cpanelbar::orderBy('order','asc')->get();
        return \Process::create('cpanelbars',null,compact('cpanelbars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if(request('parent')!=''){
            $parent_id=request('parent');
            }else {
            $parent_id = 0;
        }
        $this->validate($request,[
            'translate' => [
                'name' => 'required',
            ],

        ]);
        return \Process::store($request,'cpanelbars',[
            'translate' => [
                'name',
            ],
            'parent_id'=>$parent_id,
            'icon'=>request('icon'),

        ],cp.'cpanelbars',function ($query){
            return redirect(cp.'cpanelbars');
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
    public function edit(Request $request ,$id)
    {
        return \Process::edit('cpanelbars',$id);
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
        $row=Cpanelbar::find($id);
        $this->validate($request,[
            'translate' => [
                'name' => 'required',
            ],
            //'parent_id' => 'required',

        ]);

        if(!empty(request('icon'))){
            $row->icon=request('icon');
            $row->save();
        }

        return \Process::update($request,$id,'cpanelbars',[
            //'translate' => ['name'],
            'translate' => [
                'name',
            ],
//            'name'=>request('name'),
//            'content'=>request('content'),
            'parent_id'=>request('parent'),


        ],cp.'cpanelbars',function ($query){
            return redirect(cp.'cpanelbars');
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
        return  \Process::deletewithparent($request,$id,'cpanelbars');
    }
    ///////////
    ///
    ///

    public function order(Request $request)
    {
        $data=json_decode($request->data,true);
        // dd($data);
        return \Process::order($data,'cpanelbars',0);
    }
}
