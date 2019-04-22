<?php
namespace App\Helpers\Classes\Relation;
//use Illuminate\Http\Request;
use App\Image;

trait ImageRelation{
    public function image()
    {
        $extends=str_singular($this->getTable());
        $getUrl= $this->hasMany(Image::class,'parent')->where ('extends',$extends);
        if($getUrl->exists()){
            //if (file_exists(public_path($getUrl->first()->url)))
            if (\File::exists(base_path($getUrl->first()->url)))
            {
               // dd($getUrl->first()->url);
                return url($getUrl->first()->url);

            }else{
                return url(cp_url.'/img/noimage.jpg');
            }

        }else{
            return url(cp_url.'/img/noimage.jpg');
        }
    }

    public function firstimage()
    {
        $extends=str_singular($this->getTable());

        $getUrl= $this->hasMany(Image::class,'parent')->where ('extends',$extends);
        if($getUrl->exists()){
            if (file_exists(public_path($getUrl->first()->url)))
            {
                return url('public/' . $getUrl->first()->url);
            }else{
                return url(cp_url.'/img/noimage.jpg');
            }

        }else{
            return url(cp_url.'/img/noimage.jpg');
        }

    }
    public function lastimage()
    {
        $extends=str_singular($this->getTable());

        $getUrl= $this->hasMany(Image::class,'parent')->where ('extends',$extends);
        if($getUrl->exists()){
            if (file_exists(public_path($getUrl->get()->last()->url)))
            {
                return url('public/' . $getUrl->get()->last()->url);
            }else{
                return url(cp_url.'img/noimage.jpg');
            }

        }else{
            return url(cp_url.'img/noimage.jpg');
        }
    }
    public function images()
    {
        $extends=str_singular($this->getTable());
        $urls=[];
        $getUrls= $this->hasMany(Image::class,'parent')->where('extends',$extends);
        //dd($getUrls);
        if($getUrls->exists())
        {
            foreach ($getUrls->pluck('url')->toArray() as $getUrl)
            {
                if (file_exists(base_path($getUrl))) {
                    $urls[] = url($getUrl);
                } else {
                    $urls[] = url(cp_url . '/img/noimage.jpg');
                }

            }
            return $urls;
        }else{
            return [url(cp_url . '/img/noimage.jpg')];
        }


    }
    public function defaultimg()
    {
        $extends=str_singular($this->getTable());
        $getUrl= $this->hasMany(Image::class,'parent')
            ->where ('extends',$extends)
            ->where ('default',1)
        ;
        if($getUrl->exists()){
            //if (file_exists(public_path($getUrl->first()->url)))
            if (\File::exists(base_path($getUrl->first()->url)))
            {
                return url($getUrl->first()->url);

            }else{
                return url(cp_url.'/img/noimage.jpg');
            }

        }else{
            return url(cp_url.'/img/noimage.jpg');
        }
    }
    public function imagedefault()
    {
        $extends=str_singular($this->getTable());
        $getUrl= $this->hasMany(Image::class,'parent')
            ->where ('extends',$extends)
            ->where ('default',1)
        ;
        if($getUrl->exists()){
            //if (file_exists(public_path($getUrl->first()->url)))
            if (\File::exists(base_path($getUrl->first()->thumb_url)))
            {
                return url($getUrl->first()->thumb_url);

            }else{
                return url(cp_url.'/img/noimage.jpg');
            }

        }else{
            return url(cp_url.'/img/noimage.jpg');
        }
    }
    public function imagespath()
    {
        $extends=str_singular($this->getTable());
        $urls=[];
        $getUrls= $this->hasMany(Image::class,'parent')->where('extends',$extends);

        if($getUrls->exists())
        {
            foreach ($getUrls->pluck('thumb_url')->toArray() as $getUrl)
            {
                    //$urls[] = url($getUrl);
                    $urls[] = $getUrl;

            }
            return $urls;
        }else{
            return [url(cp_url . '/img/noimage.jpg')];
        }


    }
}