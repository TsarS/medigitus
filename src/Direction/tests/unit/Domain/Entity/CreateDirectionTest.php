<?php
declare(strict_types=1);

namespace Direction\tests\unit\Domain\Entity;


use DateTimeImmutable;
use Direction\Domain\Events\DirectionRemoved;
use Direction\Domain\VO\Id;
use PHPUnit\Framework\TestCase;
use Direction\Domain\Entity\Direction;
use Direction\Domain\Events\DirectionCreated;
use Direction\Domain\Events\DirectionRenamed;

final class CreateDirectionTest extends TestCase
{
    public function testItShouldCreateDirectionEntity(): void {
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
    public function testCanRemoved():void {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Хиромантия',
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($id, $direction->getId());
        $this->assertNotEmpty($events = $direction->releaseEvents());
        $this->assertInstanceOf(DirectionCreated::class, end($events));
        $direction->remove();
        $this->assertNotEmpty($events = $direction->releaseEvents());
        $this->assertInstanceOf(DirectionRemoved::class, end($events));
    }
}