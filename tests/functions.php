<?php

use SportFinder\Time\Tests\Factory;

function t($time)
{
    return Factory::createFromTime($time);
}
