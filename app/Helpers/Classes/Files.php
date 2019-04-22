<?php
namespace App\Helpers\Classes;
use Illuminate\Http\Request;
use  App\Image;


class Files{
    static $dir = 'uploads/';

    public static function upload(Request $request,$extends,$parent)
    {

        $filepath='public/uploads/'.str_plural($extends).'/';
        $dirpath='uploads/'.str_plural($extends).'/';
        if(!\File::exists(public_path(self::$dir))) {
            \File::makeDirectory(public_path(self::$dir), $mode = 0777, true, true);
        }
        if(!\File::exists(public_path($dirpath))) {
            \File::makeDirectory(public_path($dirpath), $mode = 0777, true, true);
        }
        if(!empty(request('imgbox'))){
            $imgs=explode(",",request('imgbox'));
            //dd(end($imgs));
            foreach ($imgs as $imgpath){
                if($imgpath!=''){
                //$imgurl=$imgpath;
                $thumbimgurl=str_replace('\\','/',$imgpath);
                $imgurl=str_replace('thumb/thumb_','',$imgpath);
                $img= new Image;
                $img->extends=$extends;
                $img->parent=$parent;
                if(request('default')==$thumbimgurl){
                    $img->default=1;
                }else{
                    $img->default=0;
                }
                $img->url=$imgurl;
                $img->thumb_url=$thumbimgurl;
                $img->save();
                }
            }

        }
        elseif (count($request->file())>0)
        {
            foreach ($request->file() as $name=>$file )
            {
                $input=$request->file($name);
                if(is_array($input))
                {
                    foreach ($input as $file)
                    {
                        $fileName=uniqid($extends).'.'.$file->getClientOriginalExtension();
                        $file->move(public_path($dirpath),$fileName);
                        $img = Image::where('extends', $extends)->where('parent', $parent)->first()->first();
                        if ($img->url){
                            $imgFile = base_path($img->url);
                            //dd($imgFile);
                            if (\File::exists($imgFile)) {
                                @unlink($imgFile);
                            }
                            $img->url=$filepath.$fileName;
                            $img->save();
                        }else {
                            $img = new Image;
                            $img->extends = $extends;
                            $img->parent = $parent;
                            $img->url = $filepath . $fileName;
                            $img->save();
                        }
                    }

                }else {
                    $img = Image::where('extends', $extends)->where('parent', $parent)->first();
                    $fileName=uniqid($extends).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path($dirpath),$fileName);

                        if ($img!=null){
                            $imgFile = base_path($img->url);
                               //dd($imgFile);
                            if (\File::exists($imgFile)) {
                                @unlink($imgFile);
                            }
                            $img->url=$filepath.$fileName;
                            $img->save();
                            }else{
                            $img= new Image;
                            $img->extends=$extends;
                            $img->parent=$parent;
                            $img->url=$filepath.$fileName;
                            $img->save();
                        }
                }

            }
        }
    }

    public static function  delete($extends,$parent)
    {
        $images=Image::where('extends',$extends)->where('parent',$parent)->first();
        if(!empty($images)){
        $imgFile=base_path($images->url);
        if(\File::exists($imgFile))
        {
            @unlink($imgFile);
        }/****/
        $images->delete();
        }
    }
    public static function  delete_images($extends,$parent)
    {
        $images=Image::where('extends',$extends)->where('parent',$parent);
        foreach ($images->get() as $image)
        {
            $imgFile=public_path($image->url);
            if(file_exists($imgFile))
            {
                @unlink($imgFile);
            }/****/
        }
        $images->delete();


    }

}