<?php

namespace SportFinder\Time\Tests\DateSlot;

use PHPUnit\Framework\TestCase;
use SportFinder\Time\ComparatorInterface;
use SportFinder\Time\Tests\Factory;

class ComparatorTraitTest extends TestCase
{

    public function beforeDateData()
    {
        return [
            '1999 < 2000'         => [true, Factory::date('1999-12-31'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 2000 < 2000'       => [false, Factory::date('2000-01-01'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 2000-02-20 < 2000' => [false, Factory::date('2000-01-20'), Factory::dateslot('2000-01-01', '2000-01-10')],

            '1999 < 2000 (2)'                                       => [
                true,
                Factory::dateslot('1999-12-01', '1999-12-31'),
                Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 1999-2000 < 2000'                                    => [
                false,
                Factory::dateslot('1999-12-01', '2000-01-05'),
                Factory::dateslot('2000-01-01', '2000-01-10')],

            // sharing first.end and second.start
            '! [2000-01-01, 2000-02-01] < [2000-02-01, 2000-03-01]' =>
                [false, Factory::dateslot('2000-01-01', '2000-02-01'), Factory::dateslot('2000-02-01', '2000-03-01')],
            '[2000-01-01, 2000-02-01[ < ]2000-02-01, 2000-03-01]'   =>
                [true, Factory::dateslot('2000-01-01', '2000-02-01'), Factory::dateslot('2000-02-01', '2000-03-01'), true, false],

            '11:00 < [12:00 -> 14:00]'   => [true, Factory::time('11:00'), Factory::dateslot('12:00', '14:00')],
            '11:00 < ]12:00 -> 14:00['   => [true, Factory::time('11:00'), Factory::dateslot('12:00', '14:00')],
            '12:00 < ]12:00 -> 14:00['   => [true, Factory::time('12:00'), Factory::dateslot('12:00', '14:00'), true],
            '! 12:00 < [12:00 -> 14:00]' => [false, Factory::time('12:00'), Factory::dateslot('12:00', '14:00'), false],

            '[12:00 -> 14:00] < 15:00'   => [true, Factory::dateslot('12:00', '14:00'), Factory::time('15:00')],
            ']12:00 -> 14:00[ < 15:00'   => [true, Factory::dateslot('12:00', '14:00'), Factory::time('15:00')],
            ']12:00 -> 14:00[ < 14:00'   => [true, Factory::dateslot('12:00', '14:00'), Factory::time('14:00'), true],
            '! [12:00 -> 14:00] < 14:00' => [false, Factory::dateslot('12:00', '14:00'), Factory::time('14:00'), false],


        ];
    }

    /**
     * @dataProvider beforeDateData
     */
    public function testIsBefore($expected, ComparatorInterface $object, $parameter, $openLeft = false)
    {
        $this->assertEquals($expected, $object->isBefore($parameter, $openLeft));
    }

    public function afterDateData()
    {
        return [
            '! 1999 > 2000' => [false, Factory::date('1999-12-31'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 2000 < 2000' => [false, Factory::date('2000-01-01'), Factory::dateslot('2000-01-01', '2000-01-10')],

            '2000-01-20 > [2000-01-01, 2000-01-10]'                 =>
                [true, Factory::date('2000-01-20'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! [2000-01-01, 2000-01-10] > [2000-01-01, 2000-01-10]' =>
                [false, Factory::dateslot('2000-01-01', '2000-01-10'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '[2000-02-01, 2000-02-10] > [2000-01-01, 2000-01-10]'   =>
                [true, Factory::dateslot('2000-02-01', '2000-02-10'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! [1999-12-01, 1999-12-31] > [2000-01-01, 2000-01-10]' =>
                [false, Factory::dateslot('1999-12-01', '1999-12-31'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! [2000-01-05, 2000-02-01] > [2000-01-01, 2000-01-10]' =>
                [false, Factory::dateslot('2000-01-05', '2000-02-01'), Factory::dateslot('2000-01-01', '2000-01-10')],

            // sharing first.end and second.start
            '! [2000-01-01, 2000-02-01] > [2000-02-01, 2000-03-01]' =>
                [false, Factory::dateslot('2000-01-01', '2000-02-01'), Factory::dateslot('2000-02-01', '2000-03-01')],
            '[2000-02-01, 2000-03-01[ < ]2000-01-01, 2000-02-01]'   =>
                [true, Factory::dateslot('2000-02-01', '2000-03-01'), Factory::dateslot('2000-01-01', '2000-02-01'), true],

            '15:00 > [12:00 -> 14:00]'   => [true, Factory::time('15:00'), Factory::dateslot('12:00', '14:00')],
            '15:00 > ]12:00 -> 14:00['   => [true, Factory::time('15:00'), Factory::dateslot('12:00', '14:00')],
            '14:00 > ]12:00 -> 14:00['   => [true, Factory::time('14:00'), Factory::dateslot('12:00', '14:00'), true],
            '! 14:00 > [12:00 -> 14:00]' => [false, Factory::time('14:00'), Factory::dateslot('12:00', '14:00'), false],

            '[12:00 -> 14:00] > 11:00'   => [true, Factory::dateslot('12:00', '14:00'), Factory::time('11:00')],
            ']12:00 -> 14:00[ > 11:00'   => [true, Factory::dateslot('12:00', '14:00'), Factory::time('11:00')],
            ']12:00 -> 14:00[ > 12:00'   => [true, Factory::dateslot('12:00', '14:00'), Factory::time('12:00'), true],
            '! [12:00 -> 14:00] > 12:00' => [false, Factory::dateslot('12:00', '14:00'), Factory::time('12:00'), false],

            '! [12:00 -> 14:00] > 15:00' => [false, Factory::dateslot('12:00', '14:00'), Factory::time('15:00')],
            '! ]12:00 -> 14:00[ > 15:00' => [false, Factory::dateslot('12:00', '14:00'), Factory::time('15:00'), false],
            '! ]12:00 -> 14:00[ > 14:00' => [false, Factory::dateslot('12:00', '14:00'), Factory::time('14:00'), true],
            '! [12:00 -> 14:00] > 14:00' => [false, Factory::dateslot('12:00', '14:00'), Factory::time('14:00'), false],


        ];
    }

    /** @dataProvider afterDateData */
    public function testIsAfter($expected, ComparatorInterface $object, $parameter, $open = false)
    {
        $this->assertEquals($expected, $object->isAfter($parameter, $open));
    }


}
