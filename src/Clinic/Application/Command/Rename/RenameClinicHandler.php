<?php
declare(strict_types=1);

namespace Clinic\Application\Command\Rename;


use Clinic\Application\Command\CommandHandlerInterface;
use Clinic\Application\Command\CommandInterface;
use Clinic\Application\Event\Create\ClinicEventDispatcher;
use Clinic\Domain\Repository\ClinicReadRepository;
use Clinic\Domain\Repository\ClinicRepository;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Name;

final class RenameClinicHandler implements CommandHandlerInterface
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
        ClinicEventDispatcher $dispatcher
    )
    {
        $this->repository = $repository;
        $this->readRepository = $readRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
         $clinic = $this->readRepository->get(new Id($command->getId()));
         $clinic->rename(new Name($command->getName()));
         $this->repository->save($clinic);
         $this->dispatcher->dispatch($clinic->releaseEvents());
    }
}