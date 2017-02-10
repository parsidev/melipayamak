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
        $this->app['melipayamak'] = $this->app->singleton(MeliPayamak::class, function($app) {
            $config = config('melipayamak');
            return new MeliPayamak($config, new SoapClient($config['webserviceUrl'], ['encoding' => 'UTF-8']));
        });
    }

    public function provides() {
        return ['melipayamak'];
    }

}
