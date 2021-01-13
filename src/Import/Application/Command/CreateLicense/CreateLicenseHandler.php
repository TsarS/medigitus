<?php
declare(strict_types=1);

namespace Import\Application\Command\CreateLicense;


use DateTimeImmutable;
use Import\Application\Command\CommandHandlerInterface;
use Import\Application\Command\CommandInterface;
use Import\Domain\Entity\License;
use Import\Domain\Repository\LicenseReadRepository;
use Import\Domain\Repository\LicenseRepository;
use Import\Domain\VO\Id;

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

    public function __construct(
        LicenseRepository $repository,
        LicenseReadRepository $readRepository
    )
    {
        $this->repository = $repository;
        $this->readRepository = $readRepository;
    }

    public function __invoke(CommandInterface $command)
    {

       if ($this->readRepository->addressExist($command->getPostAddress())) {
           $this->addWorksToExistAddress($command->getPostAddress(), $command->getWorks());
       } else {
           $license = new License(
               Id::next(),
               $command->getInn(),
               $command->getPostAddress(),
               $command->getWorks(),
               new DateTimeImmutable()
           );
           $this->repository->add($license);
       }
    }
    private function addWorksToExistAddress(string $address,array $works) {

        $clinic = $this->readRepository->getByAddress($address);
        foreach ($works as $work) {
            $clinic->addWork($work["work"]);
        }

    }
}