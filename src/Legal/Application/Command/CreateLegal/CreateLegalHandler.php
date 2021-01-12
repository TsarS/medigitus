<?php
declare(strict_types=1);

namespace Legal\Application\Command\CreateLegal;


use DateTimeImmutable;
use Legal\Application\Command\CommandHandlerInterface;
use Legal\Application\Command\CommandInterface;
use Legal\Domain\Entity\Legal;
use Legal\Domain\Repository\LegalReadRepository;
use Legal\Domain\Repository\LegalRepository;
use Legal\Domain\VO\Address;
use Legal\Domain\VO\Id;
use Legal\Domain\VO\Inn;
use Legal\Domain\VO\LegalForm;
use Legal\Domain\VO\Name;
use Legal\Domain\VO\Ogrn;

final class CreateLegalHandler implements CommandHandlerInterface
{
    /**
     * @var LegalRepository
     */
    private LegalRepository $repository;
    /**
     * @var LegalReadRepository
     */
    private LegalReadRepository $readRepository;

    public function __construct(
        LegalRepository $repository,
        LegalReadRepository $readRepository
    )
    {
        $this->repository = $repository;
        $this->readRepository = $readRepository;
    }

    public function __invoke(CommandInterface $command)
    {
        if (!$this->readRepository->existsByInn($command->getInn())) {
            $legal = new Legal(
                Id::next(),
                $inn = new Inn($command->getInn()),
                $ogrn = new Ogrn($command->getOgrn()),
                $name = new Name($command->getName()),
                $legalForm = new LegalForm($command->getLegalForm()),
                $address = $command->getAddress(),
                $date = new DateTimeImmutable()
            );
            $this->repository->add($legal);
        } else return;
    }

}