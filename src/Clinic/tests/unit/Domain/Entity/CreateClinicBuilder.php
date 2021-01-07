<?php
declare(strict_types=1);

namespace Clinic\tests\unit\Domain\Entity;


use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Direction;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Name;
use DateTimeImmutable;

final class CreateClinicBuilder
{
    /**
     * @var Address
     */
    private Address $address;
    /**
     * @var Legal
     */
    private Legal $legal;
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;
    private Name $name;
    /**
     * @var Direction[]
     */
    private array $directions;


    public function __construct()
  {
      $this->id = Id::next();
      $this->legal =new Legal('7729695811',  'ООО');
      $this->name = new Name ('Клинический госпиталь на Яузе');
      $this->address = new Address(
          $country = 'Российская Федерация',
          $post_code = '111033',
          $city = 'Москва',
          $region = 'Москва',
          $street = 'Волочаевская',
          $house = 'д. 15, к.1',
          $lat = 55.8782557,
          $lon = 37.65372
      );
      $this->directions = [
          new Direction('Аллергология',1,0),
          new Direction('Травматология',1,0)
      ];
      $this->date = new DateTimeImmutable();
  }
    public function withId(Id $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }
    public function withLegal(Legal $legal): self
    {
        $clone = clone $this;
        $clone->legal = $legal;
        return $clone;
    }
    public function withName(Name $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }
    public function withAddress(Address $address): self
    {
        $clone = clone $this;
        $clone->address = $address;
        return $clone;
    }
    public function withDirections(array $directions): self
    {
        $clone = clone $this;
        $clone->directions = $directions;
        return $clone;
    }

    /**
     * @return Clinic
     */
    public function build(): Clinic
    {
        $clinic = new Clinic(
            $this->id,
            $this->legal,
            $this->name,
            $this->address,
            $this->directions,
            $this->date
        );
        return $clinic;
    }
}