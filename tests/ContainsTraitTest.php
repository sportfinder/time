<?php

namespace SportFinder\Time\Tests\DateSlot;

use SportFinder\Time\ComparatorInterface;
use SportFinder\Time\DateSlot;
use PHPUnit\Framework\TestCase;
use SportFinder\Time\Tests\Factory;

class ContainsTraitTest extends TestCase
{

    /**
     * @dataProvider DateSlot_DateTime
     * @dataProvider DateSlot_DateSlot
     * @dataProvider DateTime_DateTime
     * @dataProvider dateSlotContainsDateTime
     */
    public function testContains($expected, $object, $argument, $openLeft = false, $openRight = false)
    {
        $this->assertEquals($expected, $object->contains($argument, $openLeft, $openRight));
    }

    public function dateSlotContainsDateTime()
    {
        return [
            '! 11:00 ⊆ [12:00 -> 14:00]' => [
                false,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('11:00')],
            '! 11:00 ⊆ ]12:00 -> 14:00[' => [
                false,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('11:00'), true, true],
            '! 12:00 ⊆ ]12:00 -> 14:00[' => [
                false,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('12:00'), true, true],
            '12:00 ⊆ [12:00 -> 14:00]'    => [
                true,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('12:00')],
            '13:00 ⊆ [12:00 -> 14:00]'  => [
                true,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('13:00')],
            '14:00 ⊆ [12:00 -> 14:00]'  => [
                true,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('14:00')],
            '! 14:00 ⊆ ]12:00 -> 14:00['  => [
                false,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('14:00'), true, true],
            '! 15:00 ⊆ ]12:00 -> 14:00['  => [
                false,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('15:00'), true, true],
            '! 15:00 ⊆ [12:00 -> 14:00]'  => [
                false,
                Factory::dateslot('12:00', '14:00', Factory::FORMAT_TIME),
                Factory::time('15:00')],
        ];
    }

    public function DateSlot_DateTime()
    {
        $year2000 = Factory::dateslot('2000-01-01', '2000-12-31');
        return [
            'DateSlot_DateTime_ok1' => [true, $year2000, Factory::date('2000-01-02')],
            'DateSlot_DateTime_ok2' => [true, $year2000, Factory::date('2000-01-01')],
            'DateSlot_DateTime_ok3' => [true, $year2000, Factory::date('2000-12-31')],

            'DateSlot_DateTime_simple4' => [false, $year2000, Factory::date('2001-01-01')],
            'DateSlot_DateTime_simple5' => [false, $year2000, Factory::date('1999-12-31')],
            'DateSlot_DateTime_simple6' => [false, new DateSlot(null, null), Factory::date('1999-12-31')],

            'DateSlot_DateTime_infinity_future_1' => [true, new DateSlot(Factory::date('2000-01-01'), null), Factory::date('2010-01-01')],
            'DateSlot_DateTime_infinity_future_2' => [true, new DateSlot(Factory::date('2000-01-01'), null), Factory::date('2010-01-02')],
            'DateSlot_DateTime_infinity_future_3' => [false, new DateSlot(Factory::date('2000-01-01'), null), Factory::date('1999-12-31')],

            'DateSlot_DateTime_infinity_past_1' => [true, new DateSlot(null, Factory::date('2000-01-01')), Factory::date('1999-12-31')],
            'DateSlot_DateTime_infinity_past_2' => [true, new DateSlot(null, Factory::date('2000-01-01')), Factory::date('2000-01-01')],
            'DateSlot_DateTime_infinity_past_3' => [false, new DateSlot(null, Factory::date('2000-01-01')), Factory::date('2000-01-02')],
        ];
    }

    public function DateSlot_DateSlot()
    {
        $start    = '2000-01-01';
        $end      = '2000-12-31';
        $year2000 = Factory::dateslot($start, $end);
        return [
            'DateSlot_DateSlot_ok_1'                  => [true, $year2000, Factory::dateslot('2000-01-02', '2000-12-30')],
            'DateSlot_DateSlot_ok_2'                  => [true, $year2000, Factory::dateslot($start, $end)],
            'DateSlot_DateSlot_ko_before'             => [false, $year2000, Factory::dateslot('1999-12-01', '1999-12-31')],
            'DateSlot_DateSlot_ko_before+overlapping' => [false, $year2000, Factory::dateslot('1999-12-01', '2000-01-31')],
            'DateSlot_DateSlot_ko_after'              => [false, $year2000, Factory::dateslot('2001-01-01', '2001-12-30')],
            'DateSlot_DateSlot_ko_after+overlapping'  => [false, $year2000, Factory::dateslot('2000-12-01', '2001-12-30')],

            'DateSlot_DateSlot_ko_edge_before' => [
                false,
                new DateSlot(Factory::time("12:00"), Factory::time("13:00")),
                new DateSlot(Factory::time("13:00"), Factory::time("14:00")),
            ],
            'DateSlot_DateSlot_ok_3'           => [
                true,
                new DateSlot(Factory::time("12:00"), Factory::time("14:00")),
                new DateSlot(Factory::time("13:00"), Factory::time("14:00")),
            ],
        ];
    }

    public function DateTime_DateTime()
    {
        return [

        ];
    }
}
