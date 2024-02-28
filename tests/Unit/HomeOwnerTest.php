<?php

namespace Tests\Unit;

use App\Facades\HomeOwner;
use Tests\TestCase;

class HomeOwnerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_it_can_parse_a_title(): void
    {
        $homeOwner = "Mr John Smith";
        $this->assertSame("Mr", HomeOwner::getTitle($homeOwner));

        $homeOwner = "Mrs Jane Doe";
        $this->assertSame("Mrs", HomeOwner::getTitle($homeOwner));

        $homeOwner = "Mr Beck";
        $this->assertSame("Mr", HomeOwner::getTitle($homeOwner));

        $homeOwner = "Dr Temple";
        $this->assertSame("Dr", HomeOwner::getTitle($homeOwner));

        $homeOwner = "Mister Dave Johnson";
        $this->assertSame("Mr", HomeOwner::getTitle($homeOwner));

        $homeOwner = "John Smith";
        $this->expectException(\UnhandledMatchError::class);
        $this->assertSame("Mr", HomeOwner::getTitle($homeOwner));
    }

    public function test_it_can_parse_a_first_name(): void
    {
        $homeOwner = "Mr John Smith";
        $this->assertSame("John", HomeOwner::getFirstName($homeOwner));

        $homeOwner = "Mrs Jane Doe";
        $this->assertSame("Jane", HomeOwner::getFirstName($homeOwner));

        $homeOwner = "Mr M Jones";
        $this->assertSame(null, HomeOwner::getFirstName($homeOwner));

        $homeOwner = "Ms Charles";
        $this->assertSame(null, HomeOwner::getFirstName($homeOwner));

        $homeOwner = "Mr L. Jackson";
        $this->assertSame(null, HomeOwner::getFirstName($homeOwner));
    }

    public function test_it_can_parse_an_initial(): void
    {
        $homeOwner = "Mr John Smith";
        $this->assertSame(null, HomeOwner::getInitial($homeOwner));

        $homeOwner = "Mrs J Doe";
        $this->assertSame("J", HomeOwner::getInitial($homeOwner));

        $homeOwner = "Mr M Jones";
        $this->assertSame("M", HomeOwner::getInitial($homeOwner));

        $homeOwner = "Ms Charles";
        $this->assertSame(null, HomeOwner::getInitial($homeOwner));

        $homeOwner = "Mr L. Jackson";
        $this->assertSame("L", HomeOwner::getInitial($homeOwner));
    }

    public function test_it_can_parse_a_surname(): void
    {
        $homeOwner = "Mr John Smith";
        $this->assertSame("Smith", HomeOwner::getSurname($homeOwner));

        $homeOwner = "Mrs J Doe";
        $this->assertSame("Doe", HomeOwner::getSurname($homeOwner));

        $homeOwner = "Mr M Jones";
        $this->assertSame("Jones", HomeOwner::getSurname($homeOwner));

        $homeOwner = "Ms Charles";
        $this->assertSame("Charles", HomeOwner::getSurname($homeOwner));

        $homeOwner = "Mr L. Jackson";
        $this->assertSame("Jackson", HomeOwner::getSurname($homeOwner));
    }

    public function test_it_can_parse_people_from_a_string(): void
    {
        $owners = "Mr John Smith";
        $this->assertCount(1, HomeOwner::peopleFromString($owners));

        $owners = "Mrs Jane Doe";
        $this->assertCount(1, HomeOwner::peopleFromString($owners));

        $owners = "Mr Sampson and Mrs Jane Hope";
        $this->assertCount(2, HomeOwner::peopleFromString($owners));

        $owners = "Mr Fred Job & Mrs Fran Job";
        $this->assertCount(2, HomeOwner::peopleFromString($owners));

        $owners = "Mr & Mrs Hughes";
        $this->assertCount(2, HomeOwner::peopleFromString($owners));
    }
}
