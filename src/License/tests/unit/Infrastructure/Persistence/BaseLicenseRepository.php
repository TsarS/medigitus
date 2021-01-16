<?php
declare(strict_types=1);

namespace License\tests\unit\Infrastructure\Persistence;


use License\Domain\Repository\LicenseReadRepository;
use License\Domain\Repository\LicenseRepository;
use License\Domain\VO\Address;
use License\Domain\VO\Id;
use License\Infrastructure\Persistence\Exception\NotFoundLicenseException;
use License\tests\unit\Domain\Entity\CreateLicenseBuilder;
use PHPUnit\Framework\TestCase;

class BaseLicenseRepository extends TestCase
{
    /**
     * @var LicenseRepository
     */
    protected LicenseRepository $repository;
    /**
     * @var LicenseReadRepository
     */
    protected LicenseReadRepository $readRepository;

    public function testAdd(): void
    {
        $license = (new CreateLicenseBuilder())->build();
        $this->repository->add($license);
        $found = $this->readRepository->get($license->getId());
        $this->assertEquals($license->getId(), $found->getId());
        $this->assertEquals($license->getInn(), $found->getInn());
        $this->assertEquals($license->getName(), $found->getName());
        $this->assertEquals($license->getAddress(), $found->getAddress());
    }
    public function testGet(): void
    {
        $this->repository->add($license = (new CreateLicenseBuilder())->build());
        $found = $this->readRepository->get($license->getId());
        $this->assertNotNull($found);
        $this->assertEquals($license->getId(), $found->getId());
        $this->assertEquals($license->getWorks(), $found->getWorks());
    }
    public function testSaveLicenseRepository(): void
    {
        $changedAddress = new Address(
            'Россия',
            'Москва',
            'Москва',
            'Волочаевская',
            '15 к.1',
            '55.8782557',
            '37.65372'
        );
        $this->repository->add($license = (new CreateLicenseBuilder())->build());
        $found = $this->readRepository->get($license->getId());
        $this->assertNotNull($found);
        $found->changeAddress($changedAddress);
        $this->repository->save($found);

        $renamed = $this->readRepository->get($found->getId());
        $this->assertNotNull($renamed);
        $this->assertEquals($changedAddress->getCity(), $renamed->getAddress()->getCity());
        $this->assertEquals(1, $renamed->getStatus());
    }
    public function testGetNotFound(): void
    {
        $this->expectException(NotFoundLicenseException::class);
        $this->readRepository->get(new Id(uniqid()));
    }
}