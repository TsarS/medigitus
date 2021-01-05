<?php
declare(strict_types=1);

namespace Clinic\Domain\Entity;

use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use DateTimeImmutable;


final class Clinic
{
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
    private string $name;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

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

        $this->date = $date;
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
    public function getName(): string
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
    public function changeName(string $newName): void
    {
        $this->name = $newName;
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
}