<?php
declare(strict_types=1);

namespace Legal\Domain\Entity;


use DateTimeImmutable;
use Legal\Domain\Events\LegalCreated;
use Legal\Domain\VO\Address;
use Legal\Domain\VO\Id;
use Legal\Domain\VO\Inn;
use Legal\Domain\VO\LegalForm;
use Legal\Domain\VO\Name;
use Legal\Domain\VO\Ogrn;

final class Legal implements AggregateRoot
{
 use EventTrait;

    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var Inn
     */
    private Inn $inn;
    /**
     * @var Ogrn
     */
    private Ogrn $ogrn;
    /**
     * @var Name
     */
    private Name $name;
    /**
     * @var LegalForm
     */
    private LegalForm $legalForm;
    /**
     * @var Address
     */
    private Address $address;
    private DateTimeImmutable $date;

    public function __construct(
     Id $id,
     Inn $inn,
     Ogrn $ogrn,
     Name $name,
     LegalForm $legalForm,
     Address $address,
     DateTimeImmutable $date
 )
 {
     $this->id = $id;
     $this->inn = $inn;
     $this->ogrn = $ogrn;
     $this->name = $name;
     $this->legalForm = $legalForm;
     $this->address = $address;
     $this->date = $date;
     $this->recordEvent(new LegalCreated($this->id, $this->inn));
 }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Inn
     */
    public function getInn(): Inn
    {
        return $this->inn;
    }

    /**
     * @return Ogrn
     */
    public function getOgrn(): Ogrn
    {
        return $this->ogrn;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return LegalForm
     */
    public function getLegalForm(): LegalForm
    {
        return $this->legalForm;
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
    public function getStateOrPrivate() {
        return $this->legalForm->getPrivateOrState();
    }
}