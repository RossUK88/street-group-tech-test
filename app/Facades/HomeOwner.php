<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getInitial(string $homeOwner)
 *
 * @see \App\Helpers\HomeOwner
 */
class HomeOwner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'home-owner';
    }
}
