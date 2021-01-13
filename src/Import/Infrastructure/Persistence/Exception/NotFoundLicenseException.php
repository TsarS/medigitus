<?php
declare(strict_types=1);

namespace Import\Infrastructure\Persistence\Exception;

use LogicException;

final class NotFoundLicenseException extends LogicException
{
    public function __construct(string $name)
    {
        parent::__construct('Клиника не найдена в базе данных. Дано: ' . $name);
    }
}