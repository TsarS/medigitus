<?php
declare(strict_types=1);

namespace Direction\Application\Command\Rename;



use Direction\Application\Command\CommandHandlerInterface;
use Direction\Application\Command\CommandInterface;
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

    public function __construct(
        DirectionRepository $repository,
        DirectionReadRepository $readRepository)
    {

        $this->repository = $repository;
        $this->readRepository = $readRepository;
    }

    public function __invoke(CommandInterface $command)
    {
        $direction = $this->readRepository->get($command->getId());
        $direction->rename($command->getName());
        $this->repository->save($direction);
    }
}