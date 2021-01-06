<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Inn;

use DomainException;

class NoValidInnException extends DomainException
{

    /**
     * NoValidInnException constructor.
     * @param string $inn
     */
    public function __construct(string $inn)
    {
        parent::__construct('Inn must have a control summ. Given: ' . $inn);
    }
}