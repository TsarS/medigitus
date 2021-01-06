<?php
declare(strict_types=1);

namespace Legal\Domain\Exception\Name;

 use DomainException;

class LegalMustHaveNameException extends DomainException

{
    public function __construct(string $name)
    {
        parent::__construct('Clinic must have a name.'. $name .'Null given');
    }

}