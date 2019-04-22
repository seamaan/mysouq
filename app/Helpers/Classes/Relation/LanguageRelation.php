<?php
namespace App\Helpers\Classes\Relation;
//use Illuminate\Http\Request;

use App\Image;

trait LanguageRelation{
  public function trans($colum,$language=null)
  {
    if(is_null($language))
    {
        $lang_id=\App\Lang::where('code',app()->getlocale())->first()->id;
    }
    else
    {
        $lang_id=\App\Lang::where('code',$language)->first()->id;

    }
    //dd($lang_id);

    //$table=str_singular($this->getTable());
    $table=$this->getTable();
    //dd($table);
    $trans=@$this->hasMany('\App\Language','parent')
                 ->where('lang',$lang_id)
                 ->where('extends',$table)
                 ->where('colum',$colum);
//      dd($this->{$colum});
            return $trans->exists() ? $trans->first()->trans: $this->{$colum};
  }
}