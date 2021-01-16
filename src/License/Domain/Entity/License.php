<?php
declare(strict_types=1);

namespace License\Domain\Entity;


use DateTimeImmutable;
use License\Domain\Events\LicenseAddressChanged;
use License\Domain\Events\LicenseCreated;
use License\Domain\Events\WorkAdded;
use License\Domain\VO\Address;
use License\Domain\VO\Id;
use License\Domain\VO\Work;
use License\Domain\VO\Works;

final class License implements AggregateRoot
{
    use EventTrait;


    const ADDRESS_UNCHECKED = 0;
    const ADDRESS_CHECKED = 1;
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var string
     */
    private string $inn;
    /**
     * @var string
     */
    private string $name;
    private string $post_address;
    /**
     * @var Address
     */
    private Address $address;
    /**
     * @var Works
     */
    private Works $works;
    private DateTimeImmutable $created_date;
    /** Статус, добавлен адрес из Dadata или нет
     * @var int
     */
    private int $status;

    /**
     * License constructor.
     * @param Id $id
     * @param string $inn
     * @param string $name
     * @param string $post_address
     * @param Address $address
     * @param array $works
     * @param DateTimeImmutable $created_date
     */
    public function __construct(
        Id $id,
        string $inn,
        string $name,
        string $post_address,
        Address $address,
        array $works,
        DateTimeImmutable $created_date
    ) {

        $this->id = $id;
        $this->inn = $inn;
        $this->name = $name;
        $this->post_address = $post_address;
        $this->address = $address;
        $this->works = new Works($works);
        $this->status = self::ADDRESS_UNCHECKED;
        $this->created_date = $created_date;
        $this->recordEvent(new LicenseCreated($this->id));
    }


    /**
     * Меняет адрес у клиники
     * @param Address $address
     */
    public function changeAddress(Address $address) {
        $this->address = $address;
        $this->status = self::ADDRESS_CHECKED;
        $this->recordEvent(new LicenseAddressChanged($this->id));
    }
    /** Добавляет к лицензии новые виды работ
     * @param Work $work
     */
    public function addWork(Work $work): void
    {
        $this->works->add($work);
        $this->recordEvent(new WorkAdded($this->id));
    }




    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPostAddress(): string
    {
        return $this->post_address;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getWorks(): array
    {
        return $this->works->getAll();
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->created_date;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}