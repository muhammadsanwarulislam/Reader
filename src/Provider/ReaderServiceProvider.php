<?php
namespace Centerpoint\Reader\Provider;

use Illuminate\Support\ServiceProvider;

class ReaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ .'../../routes/web.php');
        $this->loadViewsFrom(__DIR__ .'../../views', 'reader');
        $this->mergeConfigFrom(__DIR__ .'../../config/reader.php','reader');
        $this->publishes( [
            __DIR__ .'../../config/reader.php' => config_path('reader.php')
        ]);
    }

    public function register()
    {
        
    }
}