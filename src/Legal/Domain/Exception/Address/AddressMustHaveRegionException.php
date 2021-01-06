<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Address;


use DomainException;

class AddressMustHaveRegionException extends DomainException
{
    public function __construct(string $region)
    {
        parent::__construct('Address must have a region.Null '.$region.' given');
    }
}