<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Address;


use DomainException;

class AddressMustHaveStreetException extends DomainException
{
    public function __construct(string $street)
    {
        parent::__construct('Address must have a street. ' . $street . 'Null given');
    }

}