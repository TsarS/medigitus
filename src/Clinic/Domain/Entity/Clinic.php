<?php
declare(strict_types=1);

namespace Clinic\Domain\Entity;

use Clinic\Domain\Events\ClinicRenamed;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Name;
use Clinic\Domain\VO\Status;
use DateTimeImmutable;


final class Clinic

{
    use EventTrait;
    /**
     * @var Id
     */
    private Id $id;
    /**
     * Импорт информации о юридическом лице
     * @var Legal
     */
    private Legal $legal;
    /**
     * Почтовый адрес клиники
     * @var Address
     */
    private Address $address;
    /** Массив лицензия, принадлежащий данной клинике
     * @var array
     */
    private array $licences;

    /** Название клиники. Берется от юридического лица
     * Возможно сменить
     * @var string
     */
    private Name $name;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;
    /** Массив статусов клиники
     * @var array
     */
    private array $statuses = [];

    public function __construct(
        Id $id,
        Legal $legal,
        Address $address,
        array $licences,
        DateTimeImmutable $date
    )
    {
        $this->id = $id;
        $this->legal = $legal;
        $this->address = $address;
        $this->licences = $licences;
        $this->name = new Name($this->legal->getName());
        $this->date = $date;
        $this->recordEvent(new ClinicRenamed($this->id, $this->name->getName()));
    }

    /**
     * @return string
     */
    public function getCorporateForm(): string
    {
        return $this->legal->getCorporateForm();
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /** Возврщает список лицензий
     * @return array
     */
    public function getLicences(): array
    {
        return $this->licences;
    }

    /**
     * @param string $newName
     */
    public function rename(Name $newName): void
    {
        $this->name = $newName;
        $this->recordEvent(new ClinicRenamed($this->id, $newName->getName()));
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Legal
     */
    public function getLegal(): Legal
    {
        return $this->legal;
    }
    public function isPublish(): bool
    {
        return $this->getCurrentStatus()->isActive();
    }

    public function isExcluded(): bool
    {
        return $this->getCurrentStatus()->isExcluded();
    }

    private function getCurrentStatus(): Status
    {
        return end($this->statuses);
    }
}