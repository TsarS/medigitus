<?php
declare(strict_types=1);

namespace Clinic\Domain\Exception\Directions;


use DomainException;

final class DirectionsCantBeEmptyException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Список направлений у клиники не может быть пустым: ');
    }
}