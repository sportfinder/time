<?php

namespace SportFinder\Time\DateSlot;

use PHPUnit\Framework\TestCase;
use SportFinder\Time\DateSlot;
use SportFinder\Time\Tests\Factory;

class SubtractTraitTest extends TestCase
{
    public function getDateTestData()
    {
        return [
            'equals'                   => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('2000-01-01', '2000-12-31'),
                [], // expected
            ],
            '2000 - 2000-01'           => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('2000-01-01', '2000-01-31'),
                [
                    Factory::dateslot('2000-01-31', '2000-12-31'),
                ], // expected
            ],
            '2000 - 2000-12'           => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('2000-12-01', '2000-12-31'),
                [
                    Factory::dateslot('2000-01-01', '2000-12-01'),
                ], // expected
            ],
            '2000 - [2000-12, 2001-01]'           => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('2000-12-01', '2001-01-31'),
                [
                    Factory::dateslot('2000-01-01', '2000-12-01'),
                ], // expected
            ],
            '2000 - 2001-01'           => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('2001-01-01', '2001-01-31'),
                [
                    Factory::dateslot('2000-01-01', '2000-12-31'),
                ], // expected
            ],
            '2000 - [2001-01]'           => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                [Factory::dateslot('2001-01-01', '2001-01-31')],
                [
                    Factory::dateslot('2000-01-01', '2000-12-31'),
                ], // expected
            ],
            '2000 - 2000-02'           => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('2000-02-01', '2000-03-01'),
                [
                    Factory::dateslot('2000-01-01', '2000-02-01'),
                    Factory::dateslot('2000-03-01', '2000-12-31'),
                ], // expected
            ],
            '2000 - 2000-02 - 2000-11' => [
                Factory::dateslot('2000-01-01', '2000-12-31'),
                [
                    Factory::dateslot('2000-02-01', '2000-03-01'),
                    Factory::dateslot('2000-11-01', '2000-11-30'),
                ],
                [
                    Factory::dateslot('2000-01-01', '2000-02-01'),
                    Factory::dateslot('2000-03-01', '2000-11-01'),
                    Factory::dateslot('2000-11-30', '2000-12-31'),
                ], // expected
            ],
        ];
    }

    public function getTimeTestData()
    {
        return [
            'A contains B'                   => [
                Factory::dateslot('14:30', '15:00', Factory::FORMAT_TIME),
                Factory::dateslot('14:30', '15:30', Factory::FORMAT_TIME),
                [],
            ],
        ];
    }

    /**
     * @dataProvider getDateTestData
     * @dataProvider getTimeTestData
     */
    public function testSubtract(DateSlot $object, $parameter, $expected)
    {
        $result = $object->subtract($parameter);
        $this->assertCount(count($expected), $result);
        $this->assertEquals($expected, $result);

    }
}
