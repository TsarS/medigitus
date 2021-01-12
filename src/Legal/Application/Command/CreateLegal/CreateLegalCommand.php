<?php
declare(strict_types=1);

namespace Legal\Application\Command\CreateLegal;


use Legal\Application\Command\CommandInterface;

final class CreateLegalCommand implements CommandInterface
{
    private string $inn;
    private string $ogrn;
    private string $name;
    private string $legalForm;
    private string $address;

    public function __construct(
      string $inn,
      string $ogrn,
      string $name,
      string $legalForm,
      string $address

  )
  {


      $this->inn = $inn;
      $this->ogrn = $ogrn;
      $this->name = $name;
      $this->legalForm = $legalForm;
      $this->address = $address;

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
    public function getOgrn(): string
    {
        return $this->ogrn;
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
    public function getLegalForm(): string
    {
        return $this->legalForm;
    }
    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}