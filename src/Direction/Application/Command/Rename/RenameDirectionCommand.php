<?php
declare(strict_types=1);

namespace Direction\Application\Command\Rename;


use Direction\Application\Command\CommandInterface;

final class RenameDirectionCommand implements CommandInterface
{
    private string $id;
    private string $name;

    public function __construct(
      string $id,
      string $name
  ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}