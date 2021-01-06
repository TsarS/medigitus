<?php
declare(strict_types=1);

namespace Direction\tests\unit\Domain\Entity;


use DateTimeImmutable;
use Direction\Domain\VO\Id;
use PHPUnit\Framework\TestCase;
use Direction\Domain\Entity\Direction;
use Direction\Domain\Events\DirectionCreated;
use Direction\Domain\Events\DirectionRenamed;

final class CreateDirectionTest extends TestCase
{
    public function testItShouldCreateADdirectionEntity(): void {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Аллергология',
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($id, $direction->getId());
        $this->assertEquals($name, $direction->getName());
        $this->assertNotEmpty($events = $direction->releaseEvents());
        $this->assertInstanceOf(DirectionCreated::class, end($events));
    }
    public function testCanRenameName():void {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Аллергология',
            $date = new DateTimeImmutable()
        );
        $direction->rename($newName = 'Аллергология переименованная');
        $this->assertEquals($newName, $direction->getName());
        $this->assertNotEmpty($events = $direction->releaseEvents());
        $this->assertInstanceOf(DirectionRenamed::class, end($events));
    }
}