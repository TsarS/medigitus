<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Inn;

use DomainException;

class NoValidLengthInnException extends DomainException
{


    /**
     * NoValidLengthInnException constructor.
     * @param string $inn
     */
    public function __construct(string $inn)
    {
        parent::__construct('Inn must be 10 or 12 symbols. Given: '.mb_strlen($inn). ' с инн ' . $inn);
    }
}