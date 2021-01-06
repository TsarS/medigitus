<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Address;

use DomainException;

class AddressMustHaveBuildingException extends DomainException
{
    public function __construct(string $building)
    {
        parent::__construct('Address must have a building. ' . $building . 'Null given');
    }

}