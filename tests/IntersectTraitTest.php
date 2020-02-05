<?php

namespace SportFinder\Time\DateSlot;

use PHPUnit\Framework\TestCase;
use SportFinder\Time\DateSlot;
use SportFinder\Time\Tests\Factory;

class IntersectTraitTest extends TestCase
{
    /**
     * @dataProvider getTestdata
     */
    public function testIntersect($expected, DateSlot $object, DateSlot $parameter)
    {
        $intersect = $object->intersect($parameter);
        $this->assertEquals($expected, $intersect);
        $intersect = $parameter->intersect($object);
        $this->assertEquals($expected, $intersect);
    }

    public function getTestdata()
    {
        return [
            'equals' => [
                Factory::dateslot('2000-01-01', '2000-01-31'), // expected
                Factory::dateslot('2000-01-01', '2000-01-31'),
                Factory::dateslot('2000-01-01', '2000-01-31'),
            ],
            'sharing january 2020' => [
                Factory::dateslot('2000-01-01', '2000-01-31'), // expected
                Factory::dateslot('1999-01-01', '2000-01-31'),
                Factory::dateslot('2000-01-01', '2000-12-31')
            ],
            'null_1' => [
                null, // expected
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('1999-01-01', '1999-01-31')
            ],
            'null_2' => [
                null, // expected
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('1999-01-01', '1999-12-31')
            ],
            'null_3' => [
                null, // expected
                Factory::dateslot('2000-01-01', '2000-12-31'),
                Factory::dateslot('1999-01-01', '2000-01-01')
            ],
        ];
    }
}
