<?php
declare(strict_types=1);

namespace Clinic\tests\unit\Domain\Entity;


use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Licence;
use DateTimeImmutable;

final class CreateClinicBuilder
{
    /**
     * @var Licence[]
     */
    private array $licences;
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

    public function __construct()
  {
      $this->id = Id::next();
      $this->legal =new Legal('7729695811', 'ООО "Клинический госпиталь на Яузе', 'ООО');
      $this->address = new Address(
          $country = 'Российская Федерация',
          $post_code = '111033',
          $city = 'Москва',
          $region = 'Москва',
          $street = 'Волочаевская',
          $house = 'д. 15, к.1',
          $lat = 2.34234234,
          $lon = 53.24234234
      );
      $this->licences = [new Licence($number = 'ЛО-77-01-016723',$date = '2018-09-25',['fdgdfg'])];
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
    public function withAddress(Address $address): self
    {
        $clone = clone $this;
        $clone->address = $address;
        return $clone;
    }
    public function withLicence(array $licences): self
    {
        $clone = clone $this;
        $clone->licenses = $licences;
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
            $this->address,
            $this->licences,
            $this->date
        );
        return $clinic;
    }
}