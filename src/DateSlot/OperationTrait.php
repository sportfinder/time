<?php


namespace SportFinder\Time\DateSlot;

/**
 * Trait OperationTrait
 * @package SportFinder\Time\DateSlot
 * @property $start
 * @property $end
 */
trait OperationTrait
{
    public function sub(\DateInterval $interval)
    {
        $this->start->sub($interval);
        $this->end->sub($interval);
    }

    public function add(\DateInterval $interval)
    {
        $this->start->add($interval);
        $this->end->add($interval);
    }
}