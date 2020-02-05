<?php


namespace SportFinder\Time\DateSlot;

use SportFinder\Time\DateSlot;
use SportFinder\Time\DateSlotableInterface;
use SportFinder\Time\DateSlotInterface;

trait IntersectTrait
{
    /**
     * PLEASE DONT TOUCH THE INTERVAL, EVEN THE DATETIME OBJECTS IN IT
     *
     * PRE: interval is in the same state as before
     * return a new DateSlot that represents the intersection between the current
     * object and the interval.
     *
     * ----[A.START]----[B.START]----------[A.END]----[B.END]----->
     *
     * 0) return NULL if no intersection ---[A.S]--[A.E]-------[B.S]--[B.E]-->
     * Or return a DateSlot (3 possibilities)
     * 1) (A contains B)
     *      ----[A.S]----[B.S]----------[B.E]----[A.E]----->
     *      --------------|----------------|--------------->
     *
     * 2)       ----[A.START]----[B.START]----------[A.END]----[B.END]----->
     * 3)       ----[B.START]----[A.START]----------[B.END]----[A.END]----->
     * RESULT=  -------------------|------------------|-------------------->
     *
     * @param DateSlotableInterface $toIntersect
     *
     * @return null|DateSlot
     *
     * @throws \Exception
     */
    public function intersect(DateSlotableInterface $toIntersect = null): ?DateSlotInterface
    {
        // si il n'y a pas d'intersection, on retourne null
        if ($this->isBefore($toIntersect) OR $this->isAfter($toIntersect)) {
            return null;
        }

        $start = null;
        $end = null;

        // si la session à commencer avant l'horaire, la consommation début au début de l'horaire
        // PICK UP THE START OF INTERSECTION ---START---[END]--->
        if ($toIntersect->getStart() < $this->getStart()) {
            // ------INTERVAL----------THIS------
            // ------------------------|---------
            $start = clone $this->getStart();
        } else {
            // ----------THIS------INTERVAL------
            // ------------------------|---------
            $start = clone $toIntersect->getStart();
        }

        // PICK UP THE END OF INTERSECTION ---[START]---END--->
        if ($toIntersect->getEnd() > $this->getEnd()) {
            // ----------THIS------INTERVAL------>
            // ------------|--------------------->
            $end = clone $this->getEnd();
        } else {
            // ------INTERVAL------THIS---------->
            // ----------|----------------------->
            $end = clone $toIntersect->getEnd();
        }

        $dateSlot = new DateSlot($start, $end);
        if ($dateSlot->getStart() == $dateSlot->getEnd()) {
            return null;
        }

        return $dateSlot;
    }
}