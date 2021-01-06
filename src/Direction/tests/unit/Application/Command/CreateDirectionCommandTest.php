<?php
declare(strict_types=1);

namespace Direction\tests\unit\Application\Command;


use Direction\Application\Command\Create\CreateDirectionCommand;
use PHPUnit\Framework\TestCase;

final class CreateDirectionCommandTest extends TestCase
{
    public function testCreateEquipment_cCommand() :void {
        $command = new CreateDirectionCommand(
            $name = 'Аллергология'
        );
        $this->assertEquals($name,$command->getName());

    }
}