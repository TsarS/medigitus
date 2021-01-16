<?php
declare(strict_types=1);

namespace License\Infrastructure\Persistence\Exception;

use License\Domain\VO\Id;
use LogicException;

final class NotFoundLicenseException extends LogicException
{
    public function __construct(Id $id)
    {
        parent::__construct('Клиника не найдена в базе данных. Дано: ' . $id->getId());
    }
}