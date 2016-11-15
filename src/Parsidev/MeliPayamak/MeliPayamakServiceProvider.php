<?php

namespace Parsidev\MeliPayamak;

use Illuminate\Support\ServiceProvider;
use SoapClient;

class MeliPayamakServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        $this->publishes([
            __DIR__ . '/../../config/melipayamak.php' => config_path('melipayamak.php'),
        ]);
    }

    public function register() {
        $this->app['melipayamak'] = $this->app->share(function($app) {
            $config = config('melipayamak');
            return new MeliPayamak($config, new SoapClient($config['webserviceUrl']));
        });
    }

    public function provides() {
        return ['melipayamak'];
    }

}
