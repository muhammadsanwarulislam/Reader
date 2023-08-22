<?php
namespace Centerpoint\Reader;

use Illuminate\Support\ServiceProvider;

class ReaderServiceProvider extends ServiceProvider
{
    public static function postInstall()
    {
        $laravelVersion = app()->version();
        $installedPackages = collect(json_decode(shell_exec('composer show --all -f json')))
            ->pluck('version', 'name');
        
        // Log the gathered information
        \Log::info("Reader version: " . $laravelVersion);
        \Log::info("Installed packages: " . json_encode($installedPackages));
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ .'/routes/web.php');
        $this->loadViewsFrom(__DIR__ .'/views', 'reader');
        $this->mergeConfigFrom(__DIR__ .'/config/reader.php','reader');
        $this->publishes( [
            __DIR__ .'/config/reader.php' => config_path('reader.php')
        ]);
    }

    public function register()
    {
        
    }
}