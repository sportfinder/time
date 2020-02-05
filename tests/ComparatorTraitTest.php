<?php

namespace SportFinder\Time\Tests\DateSlot;

use PHPUnit\Framework\TestCase;
use SportFinder\Time\ComparatorInterface;
use SportFinder\Time\Tests\Factory;

class ComparatorTraitTest extends TestCase
{

    public function beforeData()
    {
        return [
            '1999 < 2000'         => [true, Factory::date('1999-12-31'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 2000 < 2000'       => [false, Factory::date('2000-01-01'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 2000-02-20 < 2000' => [false, Factory::date('2000-01-20'), Factory::dateslot('2000-01-01', '2000-01-10')],

            '1999 < 2000 (2)'    => [true, Factory::dateslot('1999-12-01', '1999-12-31'), Factory::dateslot('2000-01-01', '2000-01-10')],
            '! 1999-2000 < 2000' => [false, Factory::dateslot('1999-12-01', '2000-01-05'), Factory::dateslot('2000-01-01', '2000-01-10')],

            // sharing first.end and second.start
            '! [2000-01-01, 2000-02-01] < [2000-02-01, 2000-03-01]' =>
                [false, Factory::dateslot('2000-01-01', '2000-02-01'), Factory::dateslot('2000-02-01', '2000-03-01')],
            '[2000-01-01, 2000-02-01[ < ]2000-02-01, 2000-03-01]' =>
                [true, Factory::dateslot('2000-01-01', '2000-02-01'), Factory::dateslot('2000-02-01', '2000-03-01'), true, false],
        ];
    }

    /**
     * @dataProvider beforeData
     */
    public function testIsBefore($expected, ComparatorInterface $object, $parameter, $openLeft = false, $openRight = false)
    {
        $this->assertEquals($expected, $object->isBefore($parameter, $openLeft, $openRight));
    }

    public function afterData()
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
            '[2000-02-01, 2000-03-01[ < ]2000-01-01, 2000-02-01]' =>
                [true, Factory::dateslot('2000-02-01', '2000-03-01'), Factory::dateslot('2000-01-01', '2000-02-01'), true],


        ];
    }

    /** @dataProvider afterData */
    public function testIsAfter($expected, ComparatorInterface $object, $parameter, $openLeft = false, $openRight = false)
    {
        $this->assertEquals($expected, $object->isAfter($parameter, $openLeft, $openRight));
    }


}
