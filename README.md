# PHP Time management package 

For several projects, I had to manage time, daily schedule, weekly schedule, and more. 
I need to be able to describe a weekly schedule and generate concrete timespans from the weekly schedule.

Those classes will help you:
* manage events or any object with a starting and ending points in time
* Compute mobile phone usages & detailed consumption.
* define if a resource is available or not based on its usages
* detect availability/free time in a weekly schedule.
* generate optimized daily/weekly schedules

Project using this package:
* [SportFinder](https://www.sport-finder.com)
* [Natagora training platform](http://formations-nature.be/)
* Inspired by my experience at [BePark](http://www.bepark.eu/)

## Interfaces & classes

### Interfaces

````php
namespace SportFinder\Time;

interface DateSlotableInterface
{
    public function getStart(): ?\DateTime;
    public function getEnd(): ?\DateTime;
    public function toDateSlot(): DateSlotInterface;
}
````

````php
namespace SportFinder\Time;

interface DateSlotInterface extends DateSlotableInterface
{
    public function contains($dateTimeOrDateSlot, $openLeft = false, $openRight = false): bool;
    public function equals(DateSlotInterface $dateSlot): bool;
    public function intersect(DateSlotableInterface $interval = null);
    public function subtract($dateSlot);
    public function getDuration($unit = Units::SECOND): int;
    public function hasTimeLeft(): bool;
    public function sub(\DateInterval $interval);
    public function add(\DateInterval $interval);
}
````

````php
namespace SportFinder\Time;

interface ComparatorInterface
{
    public function isBefore($dateTimeOrDateSlot, $intervalOpen = false): bool;
    public function isAfter($dateTimeOrDateSlot, $intervalOpen = false): bool;
}
````

### Classes

* **DateSlot**: contains complex & useful business logic
* **Units**: final class that contains time units
* **DateTime**: a specialization of \DateTime that implements ComparatorInterface and DateSlotableInterface

````php
namespace SportFinder\Time;

class DateSlot implements DateSlotInterface, DurationInterface, ComparatorInterface{}
````

````php
namespace SportFinder\Time;

class DateTime extends \DateTime implements ComparatorInterface, DateSlotableInterface{}
````


## Usages

### Creating the object

````php
$from = \DateTime::createFromFormat('Y-m-d', '2020-01-01');
$to = \DateTime::createFromFormat('Y-m-d', '2020-01-31');
$dateSlot1 = new DateSlot($from, $to);
$dateSlot2 = new DateSlot($from, $to);
$dateSlot1 == $dateSlot2; // true
````

### modifying an object

````php
$dateSlot1 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-01'), \DateTime::createFromFormat('Y-m-d', '2020-01-02'));
$dateSlot2 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-02'), \DateTime::createFromFormat('Y-m-d', '2020-01-03'));
$dateSlot1 == $dateSlot2; // false
$dateSlot1->add(new \DateInterval('P1D'));
$dateSlot1 == $dateSlot2; // true
````

### comparing

````php
// [2020-01-01, 2020-01-02]
$dateSlot1 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-01'), \DateTime::createFromFormat('Y-m-d', '2020-01-02'));
// [2020-01-03, 2020-01-04]
$dateSlot2 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-03'), \DateTime::createFromFormat('Y-m-d', '2020-01-04'));
$dateSlot1->isBefore($dateSlot2); // true
$dateSlot2->isAfter($dateSlot1); // true

// [2020-01-01, 2020-01-02]
$dateSlot1 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-01'), \DateTime::createFromFormat('Y-m-d', '2020-01-02'));
// [2020-01-02, 2020-01-03]
$dateSlot2 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2020-01-02'), \DateTime::createFromFormat('Y-m-d', '2020-01-03'));
$dateSlot1->isBefore($dateSlot2); // [2020-01-01, 2020-01-02] < [2020-01-02, 2020-01-03] ? false
$dateSlot1->isBefore($dateSlot2, true); // [2020-01-01, 2020-01-02[ < ]2020-01-02, 2020-01-03] ? true
````

### intersect

````php
$dateSlot1 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2000-01-01'), \DateTime::createFromFormat('Y-m-d', '2000-01-31'));
$dateSlot2 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '1999-01-01'), \DateTime::createFromFormat('Y-m-d', '2000-01-31'));
$intersect = $dateSlot1->intersect($dateSlot2);
$expected = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2000-01-01'), \DateTime::createFromFormat('Y-m-d', '2000-01-31'));
$intersect == $expected; // True
````

### substract

````php
$year2000 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2000-01-01'), \DateTime::createFromFormat('Y-m-d', '2000-12-31'));
$february2000 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2000-02-01'), \DateTime::createFromFormat('Y-m-d', '2000-03-01'));
$november2000 = new DateSlot(\DateTime::createFromFormat('Y-m-d', '2000-11-01'), \DateTime::createFromFormat('Y-m-d', '2000-12-01'));
$year2000->subtract($february2000); // [[2000-01-01, 2000-02-01], [2000-03-01, 2000-12-31]]
$year2000->subtract([$february2000, $november2000]); // [[2000-01-01, 2000-02-01], [2000-03-01, 2000-11-01], [2000-12-01, 2000-12-31]]
````

## Open questions & reflexions

* Should DateSlot be immutable? (cfr sub and add method)
* Should we create a ImmutableDateSlot class?


## Contributing & contact

[SportFinder](https://www.sport-finder.com) is a belgian company. The platform is based on Symfony. 
We will publish as much as possible code to open source community.
We are new to OpenSource contribution.

Fee free to contact us:
* by mail: info@sport-finder.com
* personally benjamin.ellis@sport-finder.com or ellis.benjamin@outlook.com
