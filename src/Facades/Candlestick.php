<?php

namespace Reccur\Candlestick\Facades;

use Illuminate\Support\Facades\Facade;

class Candlestick extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'candlestick';
    }
}