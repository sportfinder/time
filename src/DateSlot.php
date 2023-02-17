<?php


namespace SportFinder\Time;

use SportFinder\Time\DateSlot\ComparatorTrait;
use SportFinder\Time\DateSlot\ContainsTrait;
use SportFinder\Time\DateSlot\IntersectTrait;
use SportFinder\Time\DateSlot\OperationTrait;
use SportFinder\Time\DateSlot\SubtractTrait;

class DateSlot implements DateSlotInterface, DurationInterface, ComparatorInterface
{
    use ContainsTrait;
    use IntersectTrait;
    use SubtractTrait;
    use OperationTrait;
    use ComparatorTrait;

    /** @var \DateTime */
    public $start;

    /** @var \DateTime */
    public $end;

    function __construct(\DateTime $start = null, \DateTime $end = null)
    {
        $this->setEnd($end);
        $this->setStart($start);
    }

    private function ensureValidState(): void
    {
        if($this->start == null) return;
        if($this->end == null) return;
        if ($this->start > $this->end)
            throw new InvalidStateException("start must be before end.");
    }

    public function __toString()
    {
        return 'DateSlot [' . $this->getStart()->format('d/m/Y H:i:s') .
            ' => ' . $this->getEnd()->format('d/m/Y H:i:s') . ']';
    }

    public function hasTimeLeft(): bool
    {
        return ($this->getEnd()->getTimestamp() - $this->getStart()->getTimestamp()) != 0;
    }

    public function toDateSlot(): DateSlotInterface
    {
        return clone $this;
    }

    public function getDuration($unit = Units::SECOND): ?int
    {
        if ($this->getStart() == null) return null;
        if ($this->getEnd() == null) return null;
        $duration = (abs($this->getEnd()->getTimestamp() - $this->getStart()->getTimestamp()));
        switch ($unit) {
            case Units::SECOND:
                return $duration;
                break;
            case Units::MINUTE:
                return $duration / 60;
                break;
            case Units::HOUR:
                return $duration / 3600;
                break;
        }
        throw new \Exception("invalid unit");
    }

    public function equals(DateSlotInterface $dateSlot): bool
    {
        return (
            $this->getStart() == $dateSlot->getStart() AND
            $this->getEnd() == $dateSlot->getEnd()
        );
    }

    public function __clone()
    {
        if ($this->start) $this->start = clone $this->start;
        if ($this->end) $this->end = clone $this->end;
    }

    public function setEnd($end)
    {
        if ($end == null) {
            $this->end = null;
            return $this;
        }
        $this->end = clone $end;
        $this->ensureValidState();

        return $this;
    }

    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    public function setStart($start)
    {
        if ($start == null) {
            $this->start = null;
            return $this;
        }
        $this->start = clone $start;
        $this->ensureValidState();

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }
}
