<?php
declare(strict_types=1);

namespace Legal\Domain\VO;


use Ramsey\Uuid\Uuid;

final class Id
{
    private $id;

    public function __construct(string $id)
    {

        $this->id = $id;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->getId() === $other->getId();
    }
}