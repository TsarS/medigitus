<?php
declare(strict_types=1);

namespace Import\Domain\VO;


final class Location
{

    private $lat;
    private $lon;

    public function __construct($lat, $lon)
    {
        Assertion::greaterOrEqualThan($lat, -90.0);
        Assertion::lessOrEqualThan($lat, 90.0);
        Assertion::greaterOrEqualThan($lon, -180.0);
        Assertion::lessOrEqualThan($lon, 180.0);

        $this->lat = $lat;
        $this->lon = $lon;
    }

    public function latitude()
    {
        return $this->lat;
    }

    public function longitude()
    {
        return $this->lon;
    }

    public function __toString()
    {
        return $this->lat . ' ' . $this->lon;
    }

}