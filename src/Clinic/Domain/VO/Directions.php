<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


use Clinic\Domain\Exception\Directions\DirectionsCantBeEmptyException;
use DomainException;

final class Directions
{
    private array $directions = [];

    public function __construct(array $directions)
    {
        if (!$directions) {
            throw new DirectionsCantBeEmptyException();
        }
        foreach ($directions as $direction) {
            $this->add($direction);
        }
    }
    public function add(Direction $direction): void
    {
        foreach ($this->directions as $item) {
            if ($item->isEqualTo($direction)) {
                throw new DomainException('Direction already exists.');
            }
        }
        $this->directions[] = $direction;
    }
    public function getAll(): array
    {
        return $this->directions;
    }
}