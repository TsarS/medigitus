<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Ogrn;

use DomainException;

class NoValiOgrnException extends DomainException
{
    public function __construct(string $ogrn)
    {
        parent::__construct('Ogrn must have a control summ. Given: ' . $ogrn);
    }
}