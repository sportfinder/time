<?php


namespace SportFinder\Time\Tests;


use SportFinder\Time\DateSlot;
use SportFinder\Time\DateTime;

class Factory
{

    const FORMAT_FULL = "Y-m-d H:i:s";
    const FORMAT_MEDIUM = "Y-m-d H:i";
    const FORMAT_LIGHT = "Y-m-d";

    public static function date($value, $format = self::FORMAT_LIGHT)
    {
        $dateTime = DateTime::createFromFormat($format, $value);
        switch (true)
        {
            case $format == self::FORMAT_LIGHT:
                $dateTime->setTime($dateTime->format('H'), $dateTime->format('i'), 0);
                break;
            case $format == self::FORMAT_MEDIUM:
                $dateTime->setTime(0, 0, 0);
                break;
        }
        return $dateTime;
    }

    public static function datetime($value, $format = self::FORMAT_MEDIUM)
    {
        return self::date($value, $format);
    }

    public static function dateslot($from, $to, $format = self::FORMAT_LIGHT)
    {
        return new DateSlot(self::date($from, $format), self::date($to, $format));
    }



}