<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Address;

use DomainException;

class PostCodeMustHave6DigitsException extends DomainException
{
    public function __construct(string $postcode)
    {
        parent::__construct('Address must have a 6 digits.'. $postcode .' given');
    }
}