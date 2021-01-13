<?php
declare(strict_types=1);

namespace Import\Domain\Exception;


use DomainException;

final class WorkCantBeEmptyException extends DomainException
{
    public function __construct(array $works)
    {
        parent::__construct('Список работ не может быть пустым. Дано: ' . print_r($works));
    }
}