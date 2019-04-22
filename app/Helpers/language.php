<?php
/**
 * Created by PhpStorm.
 * User: mhmd
 * Date: 03/20/2019
 * Time: 12:48 م
 */

function flags()
{
    for($i=2;$i<count(scandir(FLAGS_PATH));$i++)
    {
        $flags[]=FLAGS_URL.scandir(FLAGS_PATH)[$i];
    }
    return $flags;
}
function flag($id,$tblname=null)
{
    if($tblname){
        $model='\App\\'.ucfirst(str_singular($tblname));
        $query=$model::find($id);
    }else {
        $query = \App\Lang::find($id);
    }
    if(is_null($query->flag))
    {
        return FLAGS_URL.'ps.png';
    }else
    {
        return FLAGS_URL.$query->flag;
    }

}
function copy_lang_folder($path,$target)
{
    $path=base_path('resources/lang/'.$path);
    $target=base_path('resources/lang/'.$target);
    $path_name=scandir($path);
    @mkdir($target);
    for($i=2;$i<count($path_name);$i++)
    {
        if(is_dir($path.'/'.$path_name[$i]))
        {
            mkdir($target.'/'.$path_name[$i]);
            copy_lang_folder($path.'/'.$path_name[$i]);

        }elseif(is_file($path.'/'.$path_name[$i]))
        {
            @copy($path.'/'.$path_name[$i],$target.'/'.$path_name[$i]);
        }
    }
}
function rename_lang_folder($path,$target)
{
    $path=base_path('resources/lang/'.$path);
    $target=base_path('resources/lang/'.$target);
    @rename($path,$target);
}
function delete_lang_folder($code)
{
    $path=base_path('resources/lang/'.$code);
    $path_name=scandir($path);
    for($i=2;$i<count($path_name);$i++)
    {
        if(is_dir($path.'/'.$path_name[$i]))
        {
            $files=glob($path.'/'.$path_name[$i]);
            foreach ($files as $file)
            {
                @unlink($file);
            }
            rmdir($path.'/'.$path_name[$i]);
            delete_lang_folder($path.'/'.$path_name[$i]);
        }elseif(is_file($path.'/'.$path_name[$i]))
        {
            @unlink($path.'/'.$path_name[$i]);
        }
    }
    @rmdir($path);
}
function updateLanguage($parent,$extends,$lang,$colum,$trans)
{
    $data=[
        'parent'=>$parent,
        'extends'=>$extends,
        'lang'=>$lang,
        'colum'=>$colum,
    ];
    $language= \App\Language::where($data);
    $data['trans']=$trans;

    if($language->exists())
    {
        $update=$language->first();
        $update->trans=$trans;
        $update->save();
    }else
    {
        $update= new \App\Language;
        $update->parent=$parent;
        $update->extends=$extends;
        $update->lang=$lang;
        $update->colum=$colum;
        $update->trans=$trans;
        $update->save();

    }
}
if (!function_exists('getDir')) {
    function getDir($prefix=''){
        $lang=\App\Lang::where('code',app()->getLocale());
        if($lang->exists())
        {

            return $prefix.strtoupper($lang->first()->direction);
        }
    }
}