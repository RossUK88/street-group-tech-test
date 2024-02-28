<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;
use UnhandledMatchError;

class HomeOwner
{
    /**
     * @param  string  $homeOwner
     * @return string
     *
     * @throws UnhandledMatchError
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
     *
     * @throws Throwable
     */
    public function getFirstName(string $homeOwner): ?string
    {
        $homeOwnerParts = explode(" ", $homeOwner);
        throw_if(count($homeOwnerParts) <= 1, InvalidArgumentException::class);

        // Home Owner has all parts of a name Title, First Name, Initial, Lastname
        if(count($homeOwnerParts) === 4) {
            return $homeOwnerParts[1];
        }

        // Home Owners are required to have a Title and a Lastname therefore this means the Firstname and Initial are null
        if(count($homeOwnerParts) <= 2) {
            return null;
        }

        // This leaves us with 3 total parts, the 2nd part can now either be an Initial or a Firstname
        // Handle cases where Home Owners are sent through with a fullstpo after their intial
        $nameOrInitial = Str::replace(".", "", $homeOwnerParts[1]);

        // If there is only 1 letter in the string then this is an initial and therefore the first name is empty
        return Str::length($nameOrInitial) === 1 ? null : $homeOwnerParts[1];
    }

    /**
     * @param  string  $homeOwner
     * @return string|null
     *
     * @throws Throwable
     */
    public function getInitial(string $homeOwner): ?string
    {
        $homeOwnerParts = explode(" ", $homeOwner);
        throw_if(count($homeOwnerParts) <= 1, InvalidArgumentException::class);

        // Home Owner has all parts of a name Title, First Name, Initial, Lastname
        if(count($homeOwnerParts) === 4) {
            return $homeOwnerParts[2];
        }

        // Home Owners are required to have a Title and a Lastname therefore this means the Firstname and Initial are null
        if(count($homeOwnerParts) <= 2) {
            return null;
        }

        // This leaves us with 3 total parts, the 2nd part can now either be an Initial or a Firstname
        // Handle cases where Home Owners are sent through with a fullstpo after their intial
        $nameOrInitial = Str::replace(".", "", $homeOwnerParts[1]);

        // If there is only 1 letter in the string then this is an initial
        return Str::length($nameOrInitial) === 1 ? $nameOrInitial : null;
    }

    /**
     * @param  string  $owners
     * @return Collection
     */
    public function peopleFromString(string $owners): Collection
    {
        // Split a string by either " & " or " and "
        return Str::of($owners)->split("( \& | and )", 2);
    }
}
