<?php
declare(strict_types=1);

namespace Clinic\tests\unit\Infrastructure\Persistence;





use Clinic\Domain\Repository\ClinicReadRepository;
use Clinic\Domain\Repository\ClinicRepository;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Name;
use Clinic\Infrastructure\Persistence\Exception\NotFoundClinicException;
use Clinic\tests\unit\Domain\Entity\CreateClinicBuilder;
use PHPUnit\Framework\TestCase;

abstract class BaseClinicRepository extends TestCase
{
    /**
     * @var ClinicRepository
     */
    protected $repository;
    /**
     * @var ClinicReadRepository
     */
    protected $readRepository;

    public function testAdd(): void
    {
        $clinic = (new CreateClinicBuilder())->build();
        $this->repository->add($clinic);
        $found = $this->readRepository->get($clinic->getId());

        $this->assertEquals($clinic->getId(), $found->getId());
        $this->assertEquals($clinic->getLegal(), $found->getLegal());
        $this->assertEquals($clinic->getName(), $found->getName());
        $this->assertEquals($clinic->getAddress(), $found->getAddress());
    }
    public function testGet(): void
    {
        $this->repository->add($clinic = (new CreateClinicBuilder())->build());
        $found = $this->readRepository->get($clinic->getId());
        $this->assertNotNull($found);
        $this->assertEquals($clinic->getId(), $found->getId());
       $this->assertEquals($clinic->getDirections(), $found->getDirections());
    }
    public function testRenameRepository(): void
    {
        $this->repository->add($clinic = (new CreateClinicBuilder())->build());

        $found = $this->readRepository->get($clinic->getId());
        $this->assertNotNull($found);
        $found->rename($renamedName = new Name('Переименованный госпиталь'));
        $this->repository->save($found);

        $renamed = $this->readRepository->get($found->getId());
        $this->assertNotNull($renamed);
        $this->assertEquals($renamedName, $renamed->getName());
    }
    public function testGetNotFound(): void
    {
        $this->expectException(NotFoundClinicException::class);
        $this->readRepository->get(new Id(uniqid()));
    }


}