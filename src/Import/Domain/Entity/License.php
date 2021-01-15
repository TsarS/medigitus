<?php
declare(strict_types=1);

namespace Import\Domain\Entity;


use Import\Domain\Events\LicenseCreated;
use DateTimeImmutable;
use Import\Domain\VO\Address;
use Import\Domain\VO\Id;
use Import\Domain\VO\Work;
use Import\Domain\VO\Works;

final class License implements AggregateRoot
{

    use EventTrait;

    const ADDRESS_UNCHECKED = 0;
    const ADDRESS_CHECKED = 1;

    /**
     * @var string
     */
    private string $inn;
    /**
     * @var string
     */
    private string $post_address;
    /**
     * @var Works
     */
    private Works $works;
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $created_date;
    /**
     * @var Address
     */
    private Address $address;

    /**
     * @var
     */
    private $status;
    /**
     * @var string
     */
    private string $name;

    public function __construct(
        Id $id,
        string $inn,
        string $name,
        string $post_address,
        Address $address,
        array $works,
        DateTimeImmutable $created_date
    )
    {
        $this->inn = $inn;
        $this->post_address = $post_address;
        $this->works = new Works($works);
        $this->id = $id;
        $this->created_date = $created_date;
        $this->address = $address;
        $this->changeStatus(self::ADDRESS_UNCHECKED);
        $this->name = $name;
        $this->recordEvent(new LicenseCreated($this->id));
    }

    public function changeAddress(Address $address) {
        $this->address = $address;
    }
    /**
     * @param Work $work
     */
    public function addWork(Work $work): void
    {
       $this->works->add($work);
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @return string
     */
    public function getPostAddress(): string
    {
        return $this->post_address;
    }

    /**
     * @return Works
     */
    public function getWorks(): array
    {

        return $this->works->getAll();
    }


    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->created_date;
    }

    private function changeStatus($value): void
    {
         $this->status = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}