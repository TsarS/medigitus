<?php
declare(strict_types=1);

namespace License\Infrastructure\Persistence\Exception;


use License\Domain\VO\Id;
use LogicException;

final class NotFoundLicenseWorksException extends LogicException
{
    public function __construct(Id $id)
    {
        parent::__construct('Списка работ для клиники не найдено в базе данных. Дано: ' . $id->getId());
    }
}