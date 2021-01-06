<?php
declare(strict_types=1);

namespace Legal\Infrastructure\Persistence\Exception;

use LogicException;

final class NotFoundLegalException extends LogicException
{
    public function __construct(string $id)
    {
        parent::__construct('Юридическое лице не найдено в базе данных. Дано: ' . $id);
    }
}