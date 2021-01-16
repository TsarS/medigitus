<?php
declare(strict_types=1);

namespace License\tests\unit\Domain\Entity;


use DateTimeImmutable;
use License\Domain\Entity\License;
use License\Domain\VO\Address;
use License\Domain\VO\Id;
use License\Domain\VO\Work;

final class CreateLicenseBuilder
{
    /**
     * @var Address
     */
    private Address $address;
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $inn;
    /**
     * @var Work[]
     */
    private array $works;
    /**
     * @var string
     */
    private string $post_address;


    public function __construct()
    {
        $this->id = Id::next();
        $this->inn ='7729695811';
        $this->name = 'Клинический госпиталь на Яузе';
        $this->post_address = 'Москва, Волочаевская улица, д.15 к.1';
        $this->address = new Address(
            $country = '',
            $region = '',
            $city = '',
            $street = '',
            $house = '',
            $lat = '',
            $lon = ''
        );
        $this->works = [
            new Work('100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1.2. анестезиологии и реаниматологии', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1.19. операционному делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1.24. сестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия')
        ];
        $this->date = new DateTimeImmutable();
    }
    public function withId(Id $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }

    public function withName(string $name): self
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
    public function withWorks(array $works): self
    {
        $clone = clone $this;
        $clone->works = $works;
        return $clone;
    }

    /**
     * @return License
     */
    public function build(): License
    {
        return new License(
            $this->id,
            $this->inn,
            $this->name,
            $this->post_address,
            $this->address,
            $this->works,
            $this->date
        );
    }
}