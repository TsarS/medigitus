<?php
declare(strict_types=1);

namespace Direction\tests\unit\Infrastructure\Persistence;




use DateTimeImmutable;
use Direction\Domain\Entity\Direction;
use Direction\Domain\Repository\DirectionReadRepository;
use Direction\Domain\Repository\DirectionRepository;
use Direction\Domain\VO\Id;
use Direction\Infrastructure\Persistence\Exception\NotFoundDirectionException;
use PHPUnit\Framework\TestCase;

abstract class BaseDirectionRepository extends TestCase
{
    /**
     * @var DirectionRepository
     */
    protected DirectionRepository $repository;
    /**
     * @var DirectionReadRepository
     */
    protected DirectionReadRepository $readRepository;

    public function testAddToRepository(): void
    {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Аллергология',
            $date = new DateTimeImmutable()
        );
        $this->repository->add($direction);
        $found = $this->readRepository->get($direction->getId());

        $this->assertEquals($direction->getId(), $found->getId());
        $this->assertEquals($direction->getName(), $found->getName());

    }
    public function testGetFromRepository(): void
    {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Аллергология',
            $date = new DateTimeImmutable()
        );
        $this->repository->add($direction);
        $found = $this->readRepository->get($direction->getId());
        $this->assertNotNull($found);
        $this->assertEquals($direction->getId(), $direction->getId());
    }
    public function testGetNotFoundInRepository(): void
    {
        $this->expectException(NotFoundDirectionException::class);
        $this->readRepository->get(new Id(uniqid()));
    }
    public function testRenameInRepository(): void
    {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Офтальмология',
            $date = new DateTimeImmutable()
        );
        $this->repository->add($direction);
        $found = $this->readRepository->get($direction->getId());
        $this->assertNotNull($found);
        $found->rename($renamedName = 'Переименованное название');
        $this->repository->save($found);
        $renamed = $this->readRepository->get($found->getId());
        $this->assertNotNull($renamed);
        $this->assertEquals($renamedName, $renamed->getName());
    }
    public function testRemoveInRepository(): void
    {
        $direction = new Direction(
            $id = Id::next(),
            $name = 'Офтальмология',
            $date = new DateTimeImmutable()
        );
        $this->repository->add($direction);
        $found = $this->readRepository->get($direction->getId());
        $this->assertNotNull($found);
        $this->repository->delete($direction->getId()->getId());
        $this->expectException(NotFoundDirectionException::class);
        $this->readRepository->get($found->getId());

    }


    }