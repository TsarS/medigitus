<?php
declare(strict_types=1);

namespace Application\Command\ChangeDirection;


use Clinic\Application\Command\CommandHandlerInterface;
use Clinic\Application\Command\CommandInterface;
use Clinic\Application\Event\Create\ClinicEventDispatcher;
use Clinic\Domain\Repository\ClinicReadRepository;
use Clinic\Domain\Repository\ClinicRepository;
use Clinic\Domain\VO\Direction;
use Clinic\Domain\VO\Id;


final class ChangeDirectionHandler implements CommandHandlerInterface
{
    /**
     * @var ClinicReadRepository
     */
    private ClinicReadRepository $readRepository;
    /**
     * @var ClinicRepository
     */
    private ClinicRepository $repository;
    /**
     * @var ClinicEventDispatcher
     */
    private ClinicEventDispatcher $dispatcher;

    public function __construct(
        ClinicReadRepository $readRepository,
        ClinicRepository $repository,
        ClinicEventDispatcher $dispatcher
    )
    {
        $this->readRepository = $readRepository;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
        $clinic = $this->readRepository->get(new ID($command->getId()));
        $clinic->addDirection(new Direction($command->getDirection(), 1,1));
        $this->repository->save($clinic);
        $this->dispatcher->dispatch($clinic->releaseEvents());
    }
}