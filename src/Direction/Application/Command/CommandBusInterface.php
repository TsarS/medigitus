<?php
declare(strict_types=1);

namespace Direction\Application\Command;


interface CommandBusInterface
{
  public function dispatch(CommandInterface $command);
}