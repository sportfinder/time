<?php


namespace SportFinder\Time\DateSlot;


use SportFinder\Time\DateSlotableInterface;

trait ContainsTrait
{
    public function contains($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool
    {
        return $dateTimeOrDateSlot instanceof \DateTime ?
            $this->_containsDateTime($dateTimeOrDateSlot, $openLeft, $openRight) :
            $this->_containsDateSlot($dateTimeOrDateSlot, $openLeft, $openRight);
    }

    protected function _containsDateTime(\DateTime $datetime, $openLeft = false, $openRight = false)
    {
        if($this->getStart() == null and $this->getEnd() != null)
        {
            if($openRight) return $datetime < $this->getEnd();
            return $datetime <= $this->getEnd();
        }
        if($this->getStart() != null and $this->getEnd() == null)
        {
            if($openLeft) return $datetime > $this->getStart();
            return $datetime >= $this->getStart();
        }
        return !($this->isBeforeDateTime($datetime, $openLeft) OR $this->isAfterDateTime($datetime, $openRight));
    }

    protected function _containsDateSlot(DateSlotableInterface $dateSlot, $openLeft = false, $openRight = false)
    {
        // THIS:    ---|---|--->
        // 0)       ---|---|--->
        // 1)       ----|-|---->
        // 2)       --|---|---->
        // 3)       ----|----|->
        // 4)       --|-----|-->

        // 0 + 1
        if (($this->getStart() == null OR $dateSlot->getStart() >= $this->getStart())
            AND ($this->getEnd() == null OR $dateSlot->getEnd() <= $this->getEnd()))
            return true;

        // 2
        if (
            $openLeft AND
            $dateSlot->getEnd() > $this->getStart() AND
            $dateSlot->getEnd() <= $this->getEnd()

        ) return true;

        // 3
        if (
            $openRight AND
            $dateSlot->getStart() >= $this->getStart() AND
            $dateSlot->getStart() < $this->getEnd()

        ) return true;

        // 4
        if (
            $openLeft AND $openRight AND
            $dateSlot->getStart() <= $this->getStart() AND
            $dateSlot->getEnd() >= $this->getEnd()
        ) return true;

        return false;
    }
}