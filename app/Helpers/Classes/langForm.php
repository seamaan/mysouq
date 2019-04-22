<?php
namespace App\Helpers\Classes;

class langForm 
{
	protected  $lang = '';
    public function __construct($id)
    {
        $this->lang = $id;
    }
    public  function text($name,$value=null,$attributes=null)
    {
        $lang_id = $this->lang;
        echo view('Helpers.langForm.text',compact('name','value','attributes','lang_id'))->render();
    }
    public  function optiontext($name,$value=null,$attributes=null)
    {
        $lang_id = $this->lang;
        echo view('Helpers.langForm.optiontext',compact('name','value','attributes','lang_id'))->render();
    }


    public  function textarea($name,$value=null,$attributes=null)
    {
        $lang_id = $this->lang;
    	echo view('Helpers.langForm.textarea',compact('name','value','attributes','lang_id'))->render();
    }
    public  function transtext($name,$value=null,$attributes=null)
    {
        $lang_id = $this->lang;
        echo view('Helpers.langForm.transtext',compact('name','value','attributes','lang_id'))->render();
    }



}
