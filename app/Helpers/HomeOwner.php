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
        throw_if(count($homeOwnerParts) === 0, InvalidArgumentException::class);

        // Owner only has a title
        if(count($homeOwnerParts) === 1) {
            return null;
        }

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
        throw_if(count($homeOwnerParts) === 0, InvalidArgumentException::class);
        // Owner only has a title
        if(count($homeOwnerParts) === 1) {
            return null;
        }

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
     * @param  string  $homeOwner
     * @param  string|null  $partner
     * @return string
     *
     * @throws Throwable
     */
    public function getSurname(string $homeOwner, ?string $partner = null): string
    {
        $homeOwnerParts = explode(" ", $homeOwner);
        throw_if(count($homeOwnerParts) === 0 || count($homeOwnerParts) === 1 && is_null($partner), InvalidArgumentException::class);

        // We need to use a fall back of their Partner to get their Surname
        if(count($homeOwnerParts) === 1) {
            return self::getSurname($partner);
        }

        return end($homeOwnerParts);
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

    /**
     * @param  string  $owners
     * @return array
     */
    public function toArray(string $owners): array
    {
        $owners = self::peopleFromString($owners);

        return $owners
            ->map(function(string $person) use ($owners) {
                return [
                    'title' => self::getTitle($person),
                    'first_name' => self::getFirstName($person),
                    'initial' => self::getInitial($person),
                    'last_name' => self::getSurname($person, $owners->last()),
                ];
            })
            ->toArray();
    }
}
