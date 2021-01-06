<?php
declare(strict_types=1);

namespace Legal\tests\unit\Infrastructure\Persistence;



use Legal\Domain\Repository\LegalReadRepository;
use Legal\Domain\Repository\LegalRepository;
use Legal\Domain\VO\Id;
use Legal\Infrastructure\Persistence\Exception\NotFoundLegalException;
use Legal\tests\unit\Domain\Entity\CreateLegalBuilder;
use PHPUnit\Framework\TestCase;

abstract class BaseLegalRepository extends TestCase
{
    /**
     * @var LegalRepository
     */
    protected $repository;
    /**
     * @var LegalReadRepository
     */
    protected $readRepository;

    public function testAdd(): void
    {
        $legal = (new CreateLegalBuilder())->build();
        $this->repository->add($legal);
        $found = $this->readRepository->get($legal->getId());

        $this->assertEquals($legal->getId(), $found->getId());
        $this->assertEquals($legal->getName(), $found->getName());
        $this->assertEquals($legal->getAddress(), $found->getAddress());
    }
    public function testGet(): void
    {
        $this->repository->add($legal = (new CreateLegalBuilder())->build());
        $found = $this->readRepository->get($legal->getId());
        $this->assertNotNull($found);
        $this->assertEquals($legal->getId(), $found->getId());
    }
    public function testGetNotFound(): void
    {
        $this->expectException(NotFoundLegalException::class);
        $this->readRepository->get(new Id(uniqid()));
    }


}