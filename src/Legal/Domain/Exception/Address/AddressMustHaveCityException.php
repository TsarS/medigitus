<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Address;

use DomainException;

class AddressMustHaveCityException extends DomainException
{
    public function __construct(string $city)
    {
        parent::__construct('Address must have a region. ' . $city . 'Null given');
    }

}