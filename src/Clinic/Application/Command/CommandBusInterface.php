<?php
declare(strict_types=1);

namespace Clinic\Application\Command;


interface CommandBusInterface
{
  public function dispatch(CommandInterface $command);
}