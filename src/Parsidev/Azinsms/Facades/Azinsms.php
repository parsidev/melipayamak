<?php

namespace Parsidev\Azinsms\Facades;

use Illuminate\Support\Facades\Facade;

class Azinsms extends Facade {

    protected static function getFacadeAccessor() {
        return 'azinsms';
    }

}
