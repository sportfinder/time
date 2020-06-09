<?php


namespace SportFinder\Time\Util;


class DateTimeComparator
{
    /**
     * return true if first < second
     * ------first------second------>
     *
     * @param \DateTime $first
     * @param \DateTime $second
     *
     * @return bool
     */
    public static function before(\DateTime $first = null, \DateTime $second = null, $orEquals = false)
    {
        if ($orEquals AND $first == null AND $second == null) {
            return true;
        }
        if ($orEquals AND $first == $second) return true;
        // if first and second or both LIMITLESS, none of them are before or after each other
        if ($first == null AND $second == null) {
            return false;
        }
        // if the first date is null aka LIMITLESS or INFINITE
        // then first is after second=> so true
        // ---second---------------> first
        if ($first == null) {
            return false;
        }
        // if the second date is null aka LIMITLESS or INFINITE
        // the second is first => so false
        // ---first---------------> second
        if ($second == null) {
            return true;
        }

        if($orEquals)
        {
            return $first <= $second;
        }

        return $first < $second;
    }

    /**
     * return true if first > second
     * ------second------first------>
     *
     * @param \DateTime $first
     * @param \DateTime $second
     *
     * @return bool
     */
    public static function after(\DateTime $first = null, \DateTime $second = null, $orEquals = false)
    {
        if ($orEquals AND $first == null AND $second == null) {
            return true;
        }
        if ($orEquals AND $first == $second) return true;
        // if first and second or both LIMITLESS, none of them are before or after each other
        if ($first == null AND $second == null) {
            return false;
        }
        // if the second date is null aka LIMITLESS or INFINITE
        // then second is after => so false
        // ------------first------> second
        if ($second == null) {
            return false;
        }
        // if the first date is null, aka LIMITLESS
        // then first is after => so true
        // ------second------------> first
        if ($first == null) {
            return true;
        }

        if($orEquals)
        {
            return $first >= $second;
        }

        return $first > $second;
    }
}