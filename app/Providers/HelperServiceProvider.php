<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->includeHelpers(app_path('Helpers'));
    }
    public function includeHelpers($path)
    {
        $path_name=scandir($path);

        for($i=2;$i< count($path_name); $i++)
        {
            if(is_dir($path.'/'.$path_name[$i]))
            {
                $this->includeHelpers($path.'/'.$path_name[$i]);
            }elseif(is_file($path.'/'.$path_name[$i]))
            {
                @require_once $path.'/'.$path_name[$i];
            }
        }
    }
}
