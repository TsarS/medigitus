<?php
declare(strict_types=1);

namespace Direction\Application\Command\Create;


use DateTimeImmutable;
use Direction\Application\Command\CommandInterface;
use Direction\Application\Command\CommandHandlerInterface;
use Direction\Application\Event\DirectionEventDispatcher;
use Direction\Domain\Entity\Direction;
use Direction\Domain\Repository\DirectionRepository;
use Direction\Domain\VO\Id;

final class CreateDirectionHandler implements CommandHandlerInterface
{

    /**
     * @var DirectionRepository
     */
    private DirectionRepository $repository;
    /**
     * @var DirectionEventDispatcher
     */
    private DirectionEventDispatcher $dispatcher;

    public function __construct(
        DirectionRepository $repository,
        DirectionEventDispatcher $dispatcher) {

        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
        $direction = new Direction(
            Id::next(),
            $command->getName(),
            new DateTimeImmutable()
        );
        $this->repository->add($direction);
        $this->dispatcher->dispatch($direction->releaseEvents());
    }
}