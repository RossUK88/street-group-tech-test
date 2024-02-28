<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class HomeOwner
{
    /**
     * @param  string  $homeOwner
     * @return string
     *
     * @throws \UnhandledMatchError
     */
    public function getInitial(string $homeOwner): string
    {
        $homeOwnerParts = explode(" ", $homeOwner);

        // Initials are a required value, if it doesn't match expected values we need to handle an exception
        return match(Str::lower($homeOwnerParts[0])) {
            'mr', 'mister' => 'Mr',
            'miss', 'mrs', 'ms',
            'dr', 'prof' => Str::title($homeOwnerParts[0]),
        };
    }

}
