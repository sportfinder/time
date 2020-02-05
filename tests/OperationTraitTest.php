<?php

namespace SportFinder\Time\DateSlot;

use PHPUnit\Framework\TestCase;
use SportFinder\Time\DateSlot;

class OperationTraitTest extends TestCase
{
    public function testSub()
    {
        $dateSlot1 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-01'), \DateTime::createFromFormat('Y-m-d', '2020-01-02'));
        $dateSlot2 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-02'), \DateTime::createFromFormat('Y-m-d', '2020-01-03'));
        $this->assertNotEquals($dateSlot1, $dateSlot2);
        $dateSlot1->add(new \DateInterval('P1D'));
        $this->assertEquals($dateSlot1, $dateSlot2);
    }

    public function testAdd()
    {
        $dateSlot1 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-01'), \DateTime::createFromFormat('Y-m-d', '2020-01-02'));
        $dateSlot2 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-02'), \DateTime::createFromFormat('Y-m-d', '2020-01-03'));
        $this->assertNotEquals($dateSlot1, $dateSlot2);
        $dateSlot2->sub(new \DateInterval('P1D'));
        $this->assertEquals($dateSlot1, $dateSlot2);
    }
}
