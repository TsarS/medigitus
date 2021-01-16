<?php
declare(strict_types=1);

namespace License\Application\Command;


interface CommandBusInterface
{
  public function dispatch(CommandInterface $command);
}