<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Ogrn;

use DomainException;

class EmptyOgrnException extends DomainException
{
    public function __construct(string $ogrn)
    {
        parent::__construct('Ogrn must be. Null given: ' . $ogrn);
    }
}