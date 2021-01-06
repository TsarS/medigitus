<?php
declare(strict_types=1);

namespace Direction\Domain\Events;


use Direction\Domain\VO\Id;

final class DirectionRenamed
{
    /**
     * @var Id
     */
    private Id $id;
    private string $name;

    public function __construct(Id $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}