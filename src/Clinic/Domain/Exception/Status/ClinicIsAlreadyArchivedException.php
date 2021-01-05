<?php
declare(strict_types=1);

namespace Clinic\Domain\Exception\Status;


use DomainException;
use Throwable;

final class ClinicIsAlreadyArchivedException extends DomainException
{
    public function __construct(string $name)
    {
        parent::__construct('Клиника уже заархивирована: ' . $name);
    }
}