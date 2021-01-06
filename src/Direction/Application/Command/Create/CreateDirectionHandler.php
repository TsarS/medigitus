<?php
declare(strict_types=1);

namespace Direction\Application\Command\Create;


use DateTimeImmutable;
use Direction\Application\Command\CommandInterface;
use Direction\Application\Command\CommandHandlerInterface;
use Direction\Domain\Entity\Direction;
use Direction\Domain\Repository\DirectionRepository;
use Direction\Domain\VO\Id;

final class CreateDirectionHandler implements CommandHandlerInterface
{

    /**
     * @var DirectionRepository
     */
    private DirectionRepository $repository;

    public function __construct(DirectionRepository $repository) {

        $this->repository = $repository;
    }

    public function __invoke(CommandInterface $command)
    {
        $direction = new Direction(
            Id::next(),
            $command->getName(),
            new DateTimeImmutable()
        );
        $this->repository->add($direction);
    }
}