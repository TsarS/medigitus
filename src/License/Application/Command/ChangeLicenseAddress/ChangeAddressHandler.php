<?php
declare(strict_types=1);

namespace License\Application\Command\ChangeLicenseAddress;




use License\Application\Command\CommandHandlerInterface;
use License\Application\Command\CommandInterface;
use License\Application\Event\LicenseEventDispatcher;
use License\Application\Middleware\Location;
use License\Domain\VO\Address;
use License\Domain\VO\Id;
use License\Infrastructure\Persistence\MySQL\LicenseMySQLRepository;
use License\Infrastructure\Persistence\MySQL\LicenseReadMySQLRepository;

final class ChangeAddressHandler implements CommandHandlerInterface
{
    /**
     * @var LicenseMySQLRepository
     */
    private LicenseMySQLRepository $repository;
    /**
     * @var LicenseReadMySQLRepository
     */
    private LicenseReadMySQLRepository $readRepository;
    /**
     * @var LicenseEventDispatcher
     */
    private LicenseEventDispatcher $dispatcher;

    public function __construct(
        LicenseMySQLRepository $repository,
        LicenseReadMySQLRepository $readRepository,
        LicenseEventDispatcher $dispatcher

    )
    {
        $this->repository = $repository;
        $this->readRepository = $readRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(CommandInterface $command)
    {
        $license = $this->readRepository->get(new Id($command->getId()));
        $response = new Location($license->getPostAddress());
        $license->changeAddress(
            new Address(
            $response->getCountry(),
            $response->getRegion(),
            $response->getCity(),
            $response->getStreet(),
            $response->getHouse(),
            $response->getLat(),
            $response->getLon()
            )
        );
        $this->repository->save($license);
        $this->dispatcher->dispatch($license->releaseEvents());
    }
}