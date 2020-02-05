<?php


namespace SportFinder\Time\DateSlot;


use SportFinder\Time\DateSlotableInterface;
use SportFinder\Time\Util\DateTimeComparator as Util;

trait ComparatorTrait
{
    public function isBefore($dateTimeOrDateSlot, $intervalOpen = false): bool
    {
        return $dateTimeOrDateSlot instanceof \DateTime ?
            $this->isBeforeDateTime($dateTimeOrDateSlot, $intervalOpen) :
            $this->isBeforeDateSlot($dateTimeOrDateSlot, $intervalOpen);
    }

    public function isAfter($dateTimeOrDateSlot, $intervalOpen = false): bool
    {
        return $dateTimeOrDateSlot instanceof \DateTime ?
            $this->isAfterDateTime($dateTimeOrDateSlot, $intervalOpen) :
            $this->isAfterDateSlot($dateTimeOrDateSlot, $intervalOpen);
    }

    protected function isBeforeDateTime(\DateTime $datetime = null, $intervalOpen = false)
    {
        return Util::before($this->getEnd(), $datetime, $intervalOpen);
    }

    protected function isAfterDateTime(\DateTime $datetime = null, $intervalOpen = false)
    {
        return Util::after($this->getStart(), $datetime, $intervalOpen);
    }

    /**
     * @todo inaccurate doc
     * return true is the interval is strictly before the dateslot
     * return false if not.
     *
     * eg:
     *      interval [01/01/2014 => 30/01/2014] and dateslot [01/01/2020 => 30/01/2020]
     *      return true
     *
     *      interval [01/01/2020 => 30/01/2020] and dateslot [01/01/2014 => 30/01/2014]
     *      return false
     *
     * @param DateSlotableInterface $interval
     *
     * @return bool
     */
    protected function isBeforeDateSlot(DateSlotableInterface $interval, $intervalOpen = false)
    {
        return $this->isBeforeDateTime($interval->getStart(), $intervalOpen);
    }

    /**
     * @todo inaccurate doc
     * return true is the interval is strictly AFTER the dateslot
     * return false if not.
     *
     * eg:
     *      interval [01/01/2014 => 30/01/2014] and dateslot [01/01/2020 => 30/01/2020]
     *      return false
     *
     *      interval [01/01/2020 => 30/01/2020] and dateslot [01/01/2014 => 30/01/2014]
     *      return true
     *
     * @param DateSlotableInterface $interval
     *
     * @return bool
     */
    protected function isAfterDateSlot(DateSlotableInterface $interval = null, $intervalOpen = false)
    {
        return $this->isAfterDateTime($interval->getEnd(), $intervalOpen);
    }
}