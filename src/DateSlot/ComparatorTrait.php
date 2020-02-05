<?php


namespace SportFinder\Time\DateSlot;


use SportFinder\Time\DateSlotableInterface;
use SportFinder\Time\Util\DateTimeComparator as Util;

trait ComparatorTrait
{
    public function isBefore($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool
    {
        return $dateTimeOrDateSlot instanceof \DateTime ?
            $this->isBeforeDateTime($dateTimeOrDateSlot, $openLeft) :
            $this->isBeforeDateSlot($dateTimeOrDateSlot);
    }

    public function isAfter($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool
    {
        return $dateTimeOrDateSlot instanceof \DateTime ?
            $this->isAfterDateTime($dateTimeOrDateSlot, $openRight) :
            $this->isAfterDateSlot($dateTimeOrDateSlot);
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
    protected function isBeforeDateSlot(DateSlotableInterface $interval)
    {
        return $this->isBeforeDateTime($interval->getStart());
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