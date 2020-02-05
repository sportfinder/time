<?php


namespace SportFinder\Time;


use SportFinder\Time\DateSlot;

interface DateSlotableInterface
{
    public function getStart(): ?\DateTime;

    public function getEnd(): ?\DateTime;

    public function toDateSlot(): DateSlotInterface;
}