<?php

namespace SportFinder\Time\Tests\Util;

use SportFinder\Time\Tests\Factory;
use SportFinder\Time\Util\DateTimeComparator;
use PHPUnit\Framework\TestCase;

class DateTimeComparatorTest extends TestCase
{
    /**
     * @dataProvider time_afterDataProvider
     * @dataProvider date_afterDataProvider
     */
    public function testAfter($expected, $first, $second, $orEquals = false)
    {
        $this->assertEquals($expected, DateTimeComparator::after($first, $second, $orEquals));
    }

    public function time_afterDataProvider()
    {
        //--------------------------------------------- A > B ?
        return [
            '13:00 > 12:00' => [true, Factory::time('13:00'), Factory::time('12:00')],
            '13:00 >= 12:00' => [true, Factory::time('13:00'), Factory::time('12:00'), true],
            'NOT 12:00 > 12:00' => [false, Factory::time('12:00'), Factory::time('13:00')],
            'NOT 12:00 >= 13:00' => [false, Factory::time('12:00'), Factory::time('13:00'), true],
            'time_equals_ok' => [true, Factory::time('12:00'), Factory::time('12:00'), true],
            'time_equals_ko' => [false, Factory::time('12:00'), Factory::time('12:00'), false],
            'time_equals_ko_by_default' => [false, Factory::time('12:00'), Factory::time('12:00')],
            'time_infinite' => [true, null, Factory::time('12:00')],
        ];
    }

    public function date_afterDataProvider()
    {
        //--------------------------------------------- A > B ?
        return [
            'date_ok1' => [true, Factory::date('2000-01-02'), Factory::date('2000-01-01')],
            'date_ko1' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-02')],
            'date_equals_ok' => [true, Factory::date('2000-01-01'), Factory::date('2000-01-01'), true],
            'date_equals_ko' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01'), false],
            'date_equals_ko_by_default' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01')],
            'date_infinite' => [true, null, Factory::date('2000-01-01')],
        ];
    }

    /**
     * @dataProvider time_beforeDataProvider
     * @dataProvider date_beforeDataProvider
     */
    public function testBefore($expected, $first, $second, $orEquals = false)
    {
        $this->assertEquals($expected, DateTimeComparator::before($first, $second, $orEquals));
    }

    public function time_beforeDataProvider()
    {
        //--------------------------------------------- A < B ?
        return [
            'time_ok1' => [true, Factory::time('12:00'), Factory::time('13:00')],
            'time_ko1' => [false, Factory::time('13:00'), Factory::time('12:00')],
            'time_equals_ok' => [true, Factory::time('12:00'), Factory::time('12:00'), true],
            'time_equals_ko' => [false, Factory::time('12:00'), Factory::time('12:00'), false],
            'time_equals_ko_by_default' => [false, Factory::time('12:00'), Factory::time('12:00')],
            'time_infinity' => [false, null, Factory::time('12:00')],
        ];
    }

    public function date_beforeDataProvider()
    {
        //--------------------------------------------- A < B ?
        return [
            'date_ok1' => [true, Factory::date('2000-01-01'), Factory::date('2000-01-02')],
            'date_ko1' => [false, Factory::date('2000-01-02'), Factory::date('2000-01-01')],
            'date_equals_ok' => [true, Factory::date('2000-01-01'), Factory::date('2000-01-01'), true],
            'date_equals_ko' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01'), false],
            'date_equals_ko_by_default' => [false, Factory::date('2000-01-01'), Factory::date('2000-01-01')],
            'date_infinity' => [false, null, Factory::date('2000-01-01')],
        ];
    }
}
