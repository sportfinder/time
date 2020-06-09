<?php


namespace SportFinder\Time;


use DateTimeZone;
use SportFinder\Time\DateSlot\ComparatorTrait;

class DateTime extends \DateTime implements ComparatorInterface, DateSlotableInterface
{
    use ComparatorTrait;

    public static function createFromFormat($format, $time, DateTimeZone $timezone = null)
    {
        $innerDateTime = parent::createFromFormat($format, $time, $timezone);
        $specializedDateTime = new self();
        $specializedDateTime->setTimestamp($innerDateTime->getTimestamp());
        $specializedDateTime->setTimezone($innerDateTime->getTimezone());
        return $specializedDateTime;
    }

    public function __toString()
    {
        return $this->format('H:i');
    }


    public function getStart(): ?\DateTime
    {
        return $this;
    }

    public function getEnd(): ?\DateTime
    {
        return $this;
    }

    public function toDateSlot(): DateSlotInterface
    {
        return new DateSlot(clone $this, clone $this);
    }
}