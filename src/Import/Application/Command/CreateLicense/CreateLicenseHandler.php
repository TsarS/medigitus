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
       if ($this->clinicExist($command)) {
           $this->addWorksToExistClinic($command->getPostAddress(), $command->getWorks());
       } else {
         $license = new License(
               Id::next(),
               $command->getInn(),
               $command->getPostAddress(),
             array_map(static function ($work) {
                 return new Work(
                     $work[0],
                     $work[1],
                     $work[2],
                     $work[3]
                 );
             }, $command->getWorks()),
               new DateTimeImmutable()
           );
           $this->repository->add($license);
       }
    }
    private function addWorksToExistClinic(string $address,array $works) {
        $clinic = $this->readRepository->getByAddress($address);
        foreach ($works as $work) {
            $clinic->addWork(new Work($work[0],$work[1],$work[2],$work[3]));
            $this->repository->updateWorks($clinic);
        }
    }
     private function clinicExist($command): bool {
         if ($this->readRepository->addressExist($command->getPostAddress())) {
             return true;
         } else return false;
     }
}