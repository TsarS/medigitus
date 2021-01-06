<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Inn;


use DomainException;

class EmptyInnException extends DomainException
{

    /**
     * EmptyInnException constructor.
     * @param string $inn
     */
    public function __construct(string $inn)
    {
        parent::__construct('Inn must be. Null given: ' . $inn);
    }
}