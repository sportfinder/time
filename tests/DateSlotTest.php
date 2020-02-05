<?php

namespace SportFinder\Time\Tests;

use SportFinder\Time\DateSlot;
use PHPUnit\Framework\TestCase;
use SportFinder\Time\DateSlotInterface;
use SportFinder\Time\DateTime;
use SportFinder\Time\Units;

class DateSlotTest extends TestCase
{
    public function testCustomDateTime()
    {
        $dateTime = new DateTime("today");
        $this->assertInstanceOf(DateTime::class, $dateTime);
        $this->assertInstanceOf(DateTime::class, DateTime::createFromFormat('Y-m-d', '2000-01-01'));

        $date = DateTime::createFromFormat('Y-m-d', '2000-01-01');
        $this->assertEquals(2000, $date->format('Y'));
        $this->assertEquals(1, $date->format('m'));
        $this->assertEquals(1, $date->format('d'));

        $date->add(new \DateInterval("P1W"));
        $this->assertEquals(2000, $date->format('Y'));
        $this->assertEquals(1, $date->format('m'));
        $this->assertEquals(8, $date->format('d'));

        $this->assertEquals(DateTime::createFromFormat('Y-m-d', '2000-01-01'), DateTime::createFromFormat('Y-m-d', '2000-01-01'));

    }

    public function testToDateSlot()
    {
        $dateSlot = new DateSlot(Factory::date("2000-01-01"), Factory::date("2000-01-10"));
        $newDateSlot = $dateSlot->toDateSlot();
        $this->assertInstanceOf(DateSlotInterface::class, $newDateSlot);
//        $this->assertNotEquals($dateSlot, $newDateSlot);
        $this->assertEquals($dateSlot->getStart(), $newDateSlot->getStart());
        $this->assertEquals($dateSlot->getEnd(), $newDateSlot->getEnd());
    }

    public function testGetDuration()
    {
        $dateSlot = new DateSlot(Factory::date("2000-01-01"), Factory::date("2000-01-02"));
        $this->assertEquals(60*60*24, $dateSlot->getDuration());
        $this->assertEquals(60*24, $dateSlot->getDuration(Units::MINUTE));
        $this->assertEquals(24, $dateSlot->getDuration(Units::HOUR));
    }

    public function test__clone()
    {
        $dateSlot = new DateSlot(Factory::date("2000-01-01"), Factory::date("2000-01-10"));
        $newDateSlot = clone $dateSlot;
        $this->assertInstanceOf(DateSlotInterface::class, $newDateSlot);
        $this->assertTrue($dateSlot !== $newDateSlot);
        $this->assertNotSame($dateSlot, $newDateSlot);
        $this->assertEquals($dateSlot->getStart(), $newDateSlot->getStart());
        $this->assertEquals($dateSlot->getEnd(), $newDateSlot->getEnd());
    }

    public function testEquals()
    {
        $dateSlotA = new DateSlot(Factory::date("2000-01-01"), Factory::date("2000-01-10"));
        $dateSlotB = new DateSlot(Factory::date("2000-01-01"), Factory::date("2000-01-10"));

        $this->assertTrue($dateSlotA->equals($dateSlotB));
        $this->assertEquals($dateSlotA, $dateSlotB);
    }

    public function testHasTimeLeft()
    {
        $this->assertEquals(true, Factory::dateslot('2000-01-01', '2000-01-10')->hasTimeLeft());
        $this->assertEquals(false, Factory::dateslot('2000-01-01', '2000-01-01')->hasTimeLeft());
    }

//    public function testGetEnd()
//    {
//
//    }
//
//    public function testSetEnd()
//    {
//
//    }
//
//    public function testIsAfter()
//    {
//
//    }
//
//    public function testGetStart()
//    {
//
//    }
//
//    public function testSetStart()
//    {
//
//    }
}
