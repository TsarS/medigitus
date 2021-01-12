<?php
declare(strict_types=1);

namespace Legal\tests\unit\Domain\Entity;


use DateTimeImmutable;
use Legal\Domain\Entity\Legal;
use Legal\Domain\VO\Id;
use Legal\Domain\VO\Inn;
use Legal\Domain\VO\LegalForm;
use Legal\Domain\VO\Name;
use Legal\Domain\VO\Ogrn;

final class CreateLegalBuilder
{
    private $id;
    /**
     * @var Inn
     */
    private Inn $inn;
    /**
     * @var LegalForm
     */
    private LegalForm $legalForm;
    /**
     * @var string
     */
    private string $postAddress;
    /**
     * @var Name
     */
    private Name $name;
    /**
     * @var Ogrn
     */
    private Ogrn $ogrn;
    private DateTimeImmutable $date;

    public function __construct() {
        $this->id = Id::next();
        $this->inn = new Inn('7729695811');
        $this->ogrn = new Ogrn('1117746919597');
        $this->name = new Name('Общество с ограниченной ответственностью "Клинический госпиталь на Яузе"');
        $this->legalForm = new LegalForm('Общество с ограниченной ответственностью');
        $this->postAddress = 'Российская Федерация';
        $this->date = new DateTimeImmutable();
    }
    public function withId(Id $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }
    public function withInn(Inn $inn): self
    {
        $clone = clone $this;
        $clone->inn = $inn;
        return $clone;
    }
    public function withOgrn(Ogrn $ogrn): self
    {
        $clone = clone $this;
        $clone->ogrn = $ogrn;
        return $clone;
    }
    public function withName(Name $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }
    public function withLegalForm(LegalForm $legalForm): self
    {
        $clone = clone $this;
        $clone->legalForm = $legalForm;
        return $clone;
    }
    public function withAddress(string $postAddress): self
    {
        $clone = clone $this;
        $clone->postAddress = $postAddress;
        return $clone;
    }

    public function build(): Legal
    {
        $legal = new Legal(
            $this->id,
            $this->inn,
            $this->ogrn,
            $this->name,
            $this->legalForm,
            $this->postAddress,
            $this->date
        );
        return $legal;
    }
}