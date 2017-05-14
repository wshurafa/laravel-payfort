<?php

namespace LaravelPayfort\Facades;

use Illuminate\Support\Facades\Facade;


class Payfort extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaravelPayfort\PayfortFacadeAccessor';
    }
}