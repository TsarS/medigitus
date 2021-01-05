<?php
declare(strict_types=1);

namespace Clinic\Domain\Exception\Status;


final class ClinicIsNotArchivedException extends \DomainException
{
    public function __construct(string $name)
    {
        parent::__construct('Клиника не заархивирована: ' . $name);
    }
}