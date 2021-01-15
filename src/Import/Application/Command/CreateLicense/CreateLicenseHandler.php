<?php
declare(strict_types=1);

namespace Import\Application\Command\CreateLicense;


use DateTimeImmutable;
use Import\Application\Command\CommandHandlerInterface;
use Import\Application\Command\CommandInterface;
use Import\Application\Event\Create\ImportEventDispatcher;
use Import\Domain\Entity\License;
use Import\Domain\Repository\LicenseReadRepository;
use Import\Domain\Repository\LicenseRepository;
use Import\Domain\VO\Address;
use Import\Domain\VO\Id;
use Import\Domain\VO\Work;


final class CreateLicenseHandler implements CommandHandlerInterface
{
    /**
     * @var LicenseRepository
     */
    private LicenseRepository $repository;
    /**
     * @var LicenseReadRepository
     */
    private LicenseReadRepository $readRepository;
    /**
     * @var ImportEventDispatcher
     */
    private ImportEventDispatcher $dispatcher;

    public function __construct(
        LicenseRepository $repository,
        LicenseReadRepository $readRepository,
        ImportEventDispatcher $dispatcher

    )
    {
        $this->repository = $repository;
        $this->readRepository = $readRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
        if ($this->clinicExist($command)) {
            $this->addWorksToExistClinic($command->getPostAddress(), $command->getWorks());
        } else {
            $license = new License(
                Id::next(),
                $command->getInn(),
                $command->getName(),
                $command->getPostAddress(),
                new Address(
                    $command->getCountry(),
                    $command->getRegion(),
                    $command->getCity(),
                    $command->getStreet(),
                    $command->getHouse()
                ),

                array_map(static function ($works) {
                    return new Work(
                        $works[0],
                        $works[1],
                        $works[2],
                        $works[3]
                    );
                }, $command->getWorks()),

                new DateTimeImmutable()
            );

            $this->repository->add($license);
            $this->dispatcher->dispatch($license->releaseEvents());
        }
    }

    private function addWorksToExistClinic(string $address, array $works)
    {
        $clinic = $this->readRepository->getByAddress($address);

        foreach ($works as $work) {
            $clinic->addWork(new Work($work[0], $work[1], $work[2], $work[3]));
            $this->repository->updateWorks($clinic);
        }
    }

    private function clinicExist($command): bool
    {
        if ($this->readRepository->addressExist($command->getPostAddress())) {
            return true;
        } else return false;
    }
}