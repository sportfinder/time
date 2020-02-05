<?php


namespace SportFinder\Time\DateSlot;


trait SubtractTrait
{
    public function subtract($dateSlot)
    {
        // THIS:    ---|-----|--->

        // 0)       ---|-----|--->
        // 1)       -----|-|----->
        // 2)       -|----|------>
        // 3)       ------|----|->
        // 4)       -|---------|->

        // 0)       ------------->
        // 1)       ---|-|-|-|--->
        // 2)       ------|--|--->
        // 3)       ---|--|------>
        // 4)       ------------->

        if ($this->getStart() == null or $this->getEnd() == null) {
            throw new \Exception("infinity not implemented");
        }

        // THIS:    ---|-----|--->
        //  -       --|-------|-->
        //  =       ------------->
        if ($this->equals($dateSlot) OR (
                $dateSlot->getStart() < $this->getStart() AND
                $dateSlot->getEnd() > $this->getEnd()
            )) {
            return [];
        }

        if (
            $dateSlot->getEnd() < $this->getStart() OR
            $dateSlot->getStart() > $this->getEnd()
        ) return [clone $this];

        // 1)
        // THIS:    ---|-----|--->
        //  -       -----|-|----->
        //  =       ---|b|-|a|--->
        if (
            $dateSlot->getStart() > $this->getStart() AND
            $dateSlot->getEnd() < $this->getEnd()
        ) {
            $before = clone $this;
            $after = clone $this;

            $before->setEnd($dateSlot->getStart());
            $after->setStart($dateSlot->getEnd());

            return [
                $before,
                $after,
            ];
        }

        // 2)
        // THIS:    ---|-----|--->
        //  -       -|----|------>
        //  =       ------|--|--->

        if ($dateSlot->getStart() <= $this->getStart()) {
            $diff = clone $this;
            $diff->setStart($dateSlot->getEnd());

            return [$diff];
        }

        // 3)
        // THIS:    ---|-----|--->
        //  -       ------|----|->
        //  =       ---|--|------>

        if ($dateSlot->getEnd() >= $this->getEnd()) {
            $diff = clone $this;
            $diff->setEnd($dateSlot->getStart());

            return [$diff];
        }

        throw new \Exception("All cases should be covered");
    }
}