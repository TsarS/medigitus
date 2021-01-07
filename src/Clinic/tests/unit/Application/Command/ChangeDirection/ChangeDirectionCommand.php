<?php
declare(strict_types=1);

namespace Application\Command\ChangeDirection;


use Clinic\Application\Command\CommandInterface;

final class ChangeDirectionCommand implements CommandInterface
{
    private string $id;
    private array $direction;

    public function __construct(
        string $id,
        array $direction
    )
    {
        $this->id = $id;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getDirection(): array
    {
        return $this->direction;
    }
}