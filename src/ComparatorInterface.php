<?php


namespace SportFinder\Time;


interface ComparatorInterface
{
    public function isBefore($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool;

//    public function isStrictlyBefore($dateTimeOrDateSlot): bool;

    public function isAfter($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool;
}