<?php

namespace PcsIndonesia\FmsbriPackage;

use Illuminate\Support\ServiceProvider;
use PcsIndonesia\FmsbriPackage\Scripts\ModelsScript;

class FmsbriPackageServiceProvider extends ServiceProvider
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
        ModelsScript::delete(['unused1.php', 'unused2.php']);
        
        $this->publishes([
            __DIR__.'/../assets/Models/' => app_path('Models'),
        ], 'fmsbri-models');
    }
}
