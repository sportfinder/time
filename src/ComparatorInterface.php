<?php


namespace SportFinder\Time;


interface ComparatorInterface
{
    public function isBefore($dateTimeOrDateSlot, $intervalOpen = false): bool;
    public function isAfter($dateTimeOrDateSlot, $intervalOpen = false): bool;
}