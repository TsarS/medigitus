<?php
declare(strict_types=1);

namespace Direction\Application\Command;


interface CommandHandlerInterface
{
    public function __invoke(CommandInterface $command);
}