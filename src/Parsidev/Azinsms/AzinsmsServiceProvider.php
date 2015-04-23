<?php

namespace Parsidev\Azinsms;

use Illuminate\Support\ServiceProvider;
use SoapClient;

class AzinsmsServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        $this->publishes([
            __DIR__ . '/../../config/azinsms.php' => config_path('azinsms.php'),
        ]);
    }

    public function register() {
        $this->app['azinsms'] = $this->app->share(function($app) {
            $config = config('azinsms');
            return new Azinsms($config, new SoapClient($config['webserviceUrl']));
        });
    }

    public function provides() {
        return ['azinsms'];
    }

}
