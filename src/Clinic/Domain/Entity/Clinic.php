<?php
declare(strict_types=1);

namespace Clinic\Domain\Entity;


use Clinic\Domain\Events\ClinicCreated;
use Clinic\Domain\Events\ClinicRenamed;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Directions;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Name;
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
    /** Массив направлений, принадлежащий данной клинике
     * @var Directions
     */
    private Directions $directions;

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
    private Name $name;


    public function __construct(
        Id $id,
        Legal $legal,
        Name $name,
        Address $address,
        array $directions,
        DateTimeImmutable $date
    )
    {
        $this->id = $id;
        $this->legal = $legal;
        $this->address = $address;
        $this->directions = new Directions($directions);
        $this->date = $date;
        $this->name = $name;
        $this->recordEvent(new ClinicCreated($this->id));

    }
   public function addDirection($directions): void {
     $this->directions = $directions;
   }
    /**
     * @param Name $newName
     */
    public function rename(Name $newName): void
    {
        $this->name = $newName;
        $this->recordEvent(new ClinicRenamed($this->id));
    }

    /**
     * @return string
     */
    public function getCorporateForm(): string
    {
        return $this->legal->getCorporateForm();
    }

    public function getName() :Name {
        return $this->name;
    }


    /** Возврщает список лицензий
     * @return array
     */
    public function getDirections(): array
    {
        return $this->directions->getAll();
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