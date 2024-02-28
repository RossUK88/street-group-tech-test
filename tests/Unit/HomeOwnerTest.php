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
}
