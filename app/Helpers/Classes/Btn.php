<?php

namespace App\Helpers\Classes;

class Btn
{
    public static function create($url = null,$attr = null)
    {
        return view('Helpers.btns.create',compact('url','attr'))->render();
    }

    public static function edit($id,$url = null,$attr = null)
    {
        return view('Helpers.btns.edit',compact('id','url','attr'))->render();
    }
    public static function view($id,$modelname = null,$url = null,$attr = null)
    {
        return view('Helpers.btns.view',compact('id','modelname','url','attr'))->render();
    }
    public static function custom($id,$modelname = null,$url = null,$attr = null)
    {
        return view('Helpers.btns.custom',compact('id','modelname','url','attr'))->render();
    }
    public static function viewimg($id,$modelname = null,$url = null,$attr = null)
    {
        return view('Helpers.btns.viewimg',compact('id','modelname','url','attr'))->render();
    }
    public static function delete($id ,$name = null,$url=null)
    {
        return view('Helpers.btns.delete',compact('id','name','url'))->render();
    }
    public static function active($tblname,$id ,$name = null,$url=null)
    {
        return view('Helpers.btns.active',compact('tblname','id','name','url'))->render();
    }
    public static function deleteAll($name = null)
    {
        return view('Helpers.btns.deleteAll',compact('name'))->render();
    }

}
