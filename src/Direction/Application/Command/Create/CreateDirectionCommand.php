<?php
declare(strict_types=1);

namespace Direction\Application\Command\Create;


use Direction\Application\Command\CommandInterface;

final class CreateDirectionCommand implements CommandInterface
{
    private string $name;

    public function __construct(
      string $name
  ) {

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}