<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\LegalForm;


use DomainException;

class NoValidLegalFormException extends DomainException
{
    public function __construct(string $legalForm)
    {
        parent::__construct('LegalForm must be valid. Given: ' . $legalForm);
    }
}