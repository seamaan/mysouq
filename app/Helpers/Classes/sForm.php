<?php
namespace App\Helpers\Classes;

class sForm{

    public static function cart($id,$url=null,$attr = null)
    {
        return view('Helpers.sFrom.cart',compact('id','url','attr'))->render();
    }
    public static function washlist($id,$url=null,$attr = null)
    {
        return view('Helpers.sFrom.washlist',compact('id','url','attr'))->render();
    }
    public static function product($model,$modal=null,$url=null,$attr = null)
    {
        return view('Helpers.sFrom.product',compact('model','modal','url','attr'))->render();
    }
    public static function productmodal($model,$id=null,$url=null,$attr = null)
    {
        return view('Helpers.sFrom.productmodal',compact('model','id','url','attr'))->render();
    }
}