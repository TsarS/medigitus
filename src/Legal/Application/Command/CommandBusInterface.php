<?php
declare(strict_types=1);

namespace Legal\Application\Command;


interface CommandBusInterface
{
  public function dispatch(CommandInterface $command);
}