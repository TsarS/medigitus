<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Address;


use DomainException;

class AddressMustHavePostCodeException extends DomainException
{
    public function __construct(string $postcode)
    {
        parent::__construct('Address must have a post code.'. $postcode .' given');
    }
}