<?php
/**
 * Created by PhpStorm.
 * User: mhmd
 * Date: 03/20/2019
 * Time: 10:47 ص
 */
if (!function_exists('site')) {
    function site($row=null) {
        $settings=\App\Setting::orderBy('id', 'desc')->first();
        if($settings->exists())
        {
            if(!empty($row))
            {
                return $settings->{$row};
            }else{
                return $settings;

            }
        }
    }
}
if (!function_exists('setting')) {
    function setting() {
        return \App\Setting::orderBy('id', 'desc')->first();
    }
}
function includeimages($path){
    $filesArray = scandir($path);
    $file='';
    $photos='';
    for($i=2 ;$i<count($filesArray);$i++){

        $filepath=$path.'/'.$filesArray[$i];
        if(is_dir($filepath)){
            $file .=includeimages($filepath);
            //echo $filesArray[$i].'<br>';
        }elseif (is_file($filepath)){
            $urli=url($path.'/'.$filesArray[$i]);
            $urli=substr($urli,37);
            $albumname=substr($urli,0,-15);

            $file .=  view('cpanel.fm.allphoto', compact('urli','albumname'))->render();
            //$file .= @include('cpanel.fm.photo',array('title' => 'Header Title'));

//                $file .=' <label  for="image-'.$i.'" id="flag" class="btn btn-default flag" style="height: 90px;width: 120px;margin-bottom: 3px">
//                          <img src="'.url($path.'/'.$filesArray[$i]) .'" class="thumbnail " style="width: 100%;float: right">
//                          </label>';
//                $file .='<input  value="'.$urli.'" name="image[]" class="hidden flag-input" type="checkbox" id="image-'.$i.'" >';
//                $file .='<input type="hidden" name="albumname" value="'.$albumname.'">';
        }
    }
    return $file;

}
if (!function_exists('get_parent')) {
    function get_parent($id) {
        $category=\App\Category::find($id);
        if($category->parent_id!==null && $category->parent_id>0){
            return get_parent($category->parent_id).','.$id;
        }else{
            return $id;
        }

    }
}
if (!function_exists('load_dep')) {
    function load_dep($select = null, $dep_hide = null) {
        $departments = \App\Category::selectRaw('name as text')
            ->selectRaw('id as id')
            ->selectRaw('parent_id as parent')
            ->get(['text', 'parent', 'id']);
        $dep_arr = [];
        foreach ($departments as $department) {
            $list_arr             = [];
            $list_arr['icon']     = '';
            $list_arr['li_attr']  = '';
            $list_arr['a_attr']   = '';
            $list_arr['children'] = [];

            if ($select !== null and $select == $department->id) {

                $list_arr['state'] = [
                    'opened'   => true,
                    'selected' => true,
                    'disabled' => false,
                ];
            }

            if ($dep_hide !== null and $dep_hide == $department->id) {

                $list_arr['state'] = [
                    'opened'   => false,
                    'selected' => false,
                    'disabled' => true,
                    'hidden'   => true,
                ];
            }
            $list_arr['id']     = $department->id;
            $list_arr['parent'] = $department->parent > 0?$department->parent:'#';
            $list_arr['text']   = $department->trans('name');
            array_push($dep_arr, $list_arr);
        }
        return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);
    }
}
if (!function_exists('admin')) {
    function admin() {
        return Auth::guard('admin')->user();
    }
}
if (!function_exists('adminid')) {
    function adminid() {
        return Auth::guard('admin')->user()->id;
    }
}
if (!function_exists('menu_active')){
    function menu_active($tblname=null) {
        $active=Request::segment(2)==$tblname?'active':'';
        return $active;
    }

}
if (!function_exists('money_code')){
    function money_code($tblname=null) {
        $money_id=site('money_code');
        $money_code=\App\Currency::find($money_id)->currency_icon;
        return '<i class="fa '.$money_code.'"></i>';
    }

}
