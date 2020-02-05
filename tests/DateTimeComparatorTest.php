<?php

namespace SportFinder\Time\Tests\Util;

use SportFinder\Time\Tests\Factory;
use SportFinder\Time\Util\DateTimeComparator;
use PHPUnit\Framework\TestCase;

class DateTimeComparatorTest extends TestCase
{
    /**
     * @dataProvider afterDataProvider
     */
    public function testAfter($expected, $first, $second, $orEquals = false)
    {
        $this->assertEquals($expected, DateTimeComparator::after($first, $second, $orEquals));
    }

    public function afterDataProvider()
    {
        return [
            'ok1' => [true, Factory::date('2000-01-02'), Factory::date('2000-01-01')],
            'ko1' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-02')],
            'equals_ok' => [true, Factory::date('2000-01-01'), Factory::date('2000-01-01'), true],
            'equals_ko' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01'), false],
            'equals_ko_by_default' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01')],
            'infinite' => [true, null, Factory::date('2000-01-01')],
        ];
    }

    /**
     * @dataProvider beforeDataProvider
     */
    public function testBefore($expected, $first, $second, $orEquals = false)
    {
        $this->assertEquals($expected, DateTimeComparator::before($first, $second, $orEquals));
    }

    public function beforeDataProvider()
    {
        return [
            'ok1' => [true, Factory::date('2000-01-01'), Factory::date('2000-01-02')],
            'ko1' => [false, Factory::date('2000-01-02'), Factory::date('2000-01-01')],
            'equals_ok' => [true, Factory::date('2000-01-01'), Factory::date('2000-01-01'), true],
            'equals_ko' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01'), false],
            'equals_ko_by_default' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01')],
            'infinity' => [false, null, Factory::date('2000-01-01')],
        ];
    }
}
