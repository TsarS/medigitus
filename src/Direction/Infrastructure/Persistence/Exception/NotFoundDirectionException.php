<?php
declare(strict_types=1);

namespace Direction\Infrastructure\Persistence\Exception;

use LogicException;

final class NotFoundDirectionException extends LogicException
{
    public function __construct(string $id)
    {
        parent::__construct('Направление не найдено в базе данных. Дано: ' . $id);
    }
}