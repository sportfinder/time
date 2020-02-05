<?php


namespace SportFinder\Time;


interface DurationInterface
{
    public function getDuration($unit = Units::SECOND);
}