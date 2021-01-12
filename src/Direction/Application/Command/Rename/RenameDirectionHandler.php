<?php
declare(strict_types=1);

namespace Direction\Application\Command\Rename;



use Direction\Application\Command\CommandHandlerInterface;
use Direction\Application\Command\CommandInterface;
use Direction\Application\Event\DirectionEventDispatcher;
use Direction\Domain\Events\DirectionCreated;
use Direction\Domain\Repository\DirectionReadRepository;
use Direction\Domain\Repository\DirectionRepository;


final class RenameDirectionHandler implements CommandHandlerInterface
{
    /**
     * @var DirectionRepository
     */
    private DirectionRepository $repository;
    /**
     * @var DirectionReadRepository
     */
    private DirectionReadRepository $readRepository;
    /**
     * @var DirectionEventDispatcher
     */
    private DirectionEventDispatcher $dispatcher;

    public function __construct(
        DirectionRepository $repository,
        DirectionReadRepository $readRepository,
        DirectionEventDispatcher $dispatcher

    )
    {

        $this->repository = $repository;
        $this->readRepository = $readRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
        $direction = $this->readRepository->get($command->getId());
        $direction->rename($command->getName());
        $this->repository->save($direction);
        $this->dispatcher->dispatch($direction->releaseEvents());
    }
}