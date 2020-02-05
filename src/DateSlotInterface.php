<?php


namespace SportFinder\Time;


interface DateSlotInterface extends DateSlotableInterface
{
    public function contains($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool;

    public function equals(DateSlotInterface $dateSlot): bool;

    public function intersect(DateSlotableInterface $toIntersect = null);

    public function subtract($dateSlot);

    public function getDuration($unit = Units::SECOND): int;

    public function hasTimeLeft(): bool;

    public function sub(\DateInterval $interval);

    public function add(\DateInterval $interval);
}