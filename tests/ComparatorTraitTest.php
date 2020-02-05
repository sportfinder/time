<?php

namespace SportFinder\Time\Tests\DateSlot;

use SportFinder\Time\DateSlot\ComparatorTrait;
use PHPUnit\Framework\TestCase;
use SportFinder\Time\Tests\Factory;

class ComparatorTraitTest extends TestCase
{

    public function testIsBefore()
    {
        $this->assertTrue(Factory::date('1999-12-31')->isBefore(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertFalse(Factory::date('2000-01-01')->isBefore(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertFalse(Factory::date('2000-01-20')->isBefore(Factory::dateslot('2000-01-01', '2000-01-10')));

        $this->assertFalse(Factory::dateslot('2000-01-01', '2000-01-10')
            ->isBefore(Factory::dateslot('2000-01-01', '2000-01-10')));

        $this->assertTrue(Factory::dateslot('1999-12-01', '1999-12-31')->isBefore(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertFalse(Factory::dateslot('1999-12-01', '2000-01-05')->isBefore(Factory::dateslot('2000-01-01', '2000-01-10')));
    }


    public function testIsAfter()
    {
        $this->assertFalse(Factory::date('1999-12-31')->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertFalse(Factory::date('2000-01-01')->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertTrue(Factory::date('2000-01-20')->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));

        $this->assertFalse(Factory::dateslot('2000-01-01', '2000-01-10')
            ->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertTrue(Factory::dateslot('2000-02-01', '2000-02-10')
            ->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));

        $this->assertFalse(Factory::dateslot('1999-12-01', '1999-12-31')->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));
        $this->assertFalse(Factory::dateslot('2000-01-05', '2000-02-01')->isAfter(Factory::dateslot('2000-01-01', '2000-01-10')));
    }
}
