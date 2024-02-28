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
        $this->assertSame("Mr", HomeOwner::getInitial($homeOwner));

        $homeOwner = "Mrs Jane Doe";
        $this->assertSame("Mrs", HomeOwner::getInitial($homeOwner));

        $homeOwner = "Mr Beck";
        $this->assertSame("Mr", HomeOwner::getInitial($homeOwner));

        $homeOwner = "Dr Temple";
        $this->assertSame("Dr", HomeOwner::getInitial($homeOwner));

        $homeOwner = "Mister Dave Johnson";
        $this->assertSame("Mr", HomeOwner::getInitial($homeOwner));
    }
}
