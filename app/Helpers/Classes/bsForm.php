<?php
namespace App\Helpers\Classes;

class bsForm{
    public static function  open($options=[])
    {
        return view('Helpers.bsForm.open',compact('options'))->render();

    }
    public static function  close($options=[])
    {
        return view('Helpers.bsForm.close',compact('options'))->render();
    }
    public static function  text($name,$value=null,$attributes=[])
    {
        return view('Helpers.bsForm.text',compact('name','value','attributes'))->render();
    }
    public static function  color($name,$value=null,$attributes=[])
    {
        return view('Helpers.bsForm.color',compact('name','value','attributes'))->render();
    }
    public static function  password($name,$attributes=[])
    {
        return view('Helpers.bsForm.password',compact('name','attributes'))->render();
    }
    public static function  textarea($name,$value=null,$attributes=[])
    {
        return view('Helpers.bsForm.textarea',compact('name','value','attributes'))->render();
    }

    public static function select($name,$options,$value=null,$attributes=null)
    {
        return view('Helpers.bsForm.select',compact('name','options','value','attributes'))->render();
    }
    public static function  number ($name,$value=null,$attributes=[])
    {
        return view('Helpers.bsForm.number',compact('name','value','attributes'))->render();
    }
    public static function  url ($name,$value=null,$attributes=[])
    {
        return view('Helpers.bsForm.url',compact('name','value','attributes'))->render();
    }
    public static function  icons ($name,$value=null,$attributes=[])
    {
        return view('Helpers.bsForm.icons',compact('name','value','attributes'))->render();
    }
    public static function  checkbox ($name,$value=null,$checked=null,$attributes=[])
    {
        return view('Helpers.bsForm.checkbox',compact('name','value','checked','attributes'))->render();
    }
    public static function radio($name,$options,$value=null,$attributes=null)
    {
        return view('Helpers.bsForm.radio',compact('name','options','value','attributes'))->render();
       // return view('Helpers.bsForm.radio',compact('name','value','checked','attributes'))->render();
    }
    public static function nav_logo($attr=null)
    {
        return view('Helpers.bsForm.nav_logo',compact('attr'))->render();
        // return view('Helpers.bsForm.radio',compact('name','value','checked','attributes'))->render();
    }
      public static function logo($attr=null)
    {
        return view('Helpers.bsForm.logo',compact('attr'))->render();
        // return view('Helpers.bsForm.radio',compact('name','value','checked','attributes'))->render();
    }
    //public static function image($name=null,$url=null,$default=null,$label=null)
//        {
//        return view('Helpers.bsForm.image',compact('name','url','default','label'))->render();
//        }
    public static function image($name,$id=null)
    {
        return view('Helpers.bsForm.image',compact('name','id'))->render();
    }
    public static function translate($callback)
    {
        if (is_callable($callback))
        {
            return view('Helpers.bsForm.translate',compact('callback'))->render();
        }
    }
    public static function translate2($callback)
    {
        if (is_callable($callback))
        {
            return view('Helpers.bsForm.translate2',compact('callback'))->render();
        }
    }
    public static function otranslate($callback)
    {
        if (is_callable($callback))
        {
            return view('Helpers.bsForm.otranslate',compact('callback'))->render();
        }
    }
}