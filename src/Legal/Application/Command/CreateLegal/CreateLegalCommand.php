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
    private string $country;
    private string $post_code;
    private string $region;
    private string $city;
    private string $street;
    private string $building;

    public function __construct(
      string $inn,
      string $ogrn,
      string $name,
      string $legalForm,
      string $country,
      string $post_code,
      string $region,
      string $city,
      string $street,
      string $building
  )
  {


      $this->inn = $inn;
      $this->ogrn = $ogrn;
      $this->name = $name;
      $this->legalForm = $legalForm;
      $this->country = $country;
      $this->post_code = $post_code;
      $this->region = $region;
      $this->city = $city;
      $this->street = $street;
      $this->building = $building;
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
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->post_code;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getBuilding(): string
    {
        return $this->building;
    }
}