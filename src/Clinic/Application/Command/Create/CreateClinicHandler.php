<?php
declare(strict_types=1);

namespace Clinic\Application\Command\Create;


use Clinic\Application\Command\CommandHandlerInterface;
use Clinic\Application\Command\CommandInterface;
use Clinic\Application\Event\Create\ClinicEventDispatcher;
use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\Repository\ClinicReadRepository;
use Clinic\Domain\Repository\ClinicRepository;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Name;
use DateTimeImmutable;

final class CreateClinicHandler implements CommandHandlerInterface
{
    /**
     * @var ClinicRepository
     */
    private ClinicRepository $repository;
    /**
     * @var ClinicReadRepository
     */
    private ClinicReadRepository $readRepository;
    /**
     * @var ClinicEventDispatcher
     */
    private ClinicEventDispatcher $dispatcher;

    public function __construct(
        ClinicRepository $repository,
        ClinicReadRepository $readRepository,
        ClinicEventDispatcher  $dispatcher
    )
    {
        $this->repository = $repository;
        $this->readRepository = $readRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
        if (!$this->readRepository->ifExistByInnAndAddress(
                $command->getInn(),
                $command->getPostCode(),
                $command->getCity(),
                $command->getStreet(),
                $command->getBuilding())
        ) {
        $clinic = new Clinic(
            Id::next(),
            new Legal(
                $command->getInn(),
                $command->getLegalForm()
            ),
            new Name($command->getName()),
            new Address(
                $command->getCountry(),
                $command->getPostCode(),
                $command->getRegion(),
                $command->getCity(),
                $command->getStreet(),
                $command->getBuilding(),
                $command->getLat(),
                $command->getLon()
            ),
            $command->getDirections(),
            new DateTimeImmutable()
        );
        $this->repository->add($clinic);
        $this->dispatcher->dispatch($clinic->releaseEvents());
    } else return;
    }
}