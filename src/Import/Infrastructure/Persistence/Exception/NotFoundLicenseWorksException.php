<?php
declare(strict_types=1);

namespace Import\Infrastructure\Persistence\Exception;


use LogicException;

final class NotFoundLicenseWorksException extends LogicException
{
    public function __construct(string $name)
    {
        parent::__construct('Списка работ для клиники не найдено в базе данных. Дано: ' . $name);
    }
}