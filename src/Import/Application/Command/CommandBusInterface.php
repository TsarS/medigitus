<?php
declare(strict_types=1);

namespace Import\Application\Command;


interface CommandBusInterface
{
  public function dispatch(CommandInterface $command);
}