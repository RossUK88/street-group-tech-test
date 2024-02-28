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
    public function getTitle(string $homeOwner): string
    {
        $homeOwnerParts = explode(" ", $homeOwner);

        // Initials are a required value, if it doesn't match expected values we need to handle an exception
        return match(Str::lower($homeOwnerParts[0])) {
            'mr', 'mister' => 'Mr',
            'miss', 'mrs', 'ms',
            'dr', 'prof' => Str::title($homeOwnerParts[0]),
        };
    }

    /**
     * @param  string  $homeOwner
     * @return string|null
     */
    public function getFirstName(string $homeOwner): ?string
    {
        $homeOwnerParts = explode(" ", $homeOwner);

        // Home Owner has all parts of a name Title, First Name, Initial, Lastname
        if(count($homeOwnerParts) === 4) {
            return $homeOwnerParts[1];
        }

        return null;
    }

}
