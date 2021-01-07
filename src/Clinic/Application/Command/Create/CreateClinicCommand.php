<?php
declare(strict_types=1);

namespace Clinic\Application\Command\Create;


use Clinic\Application\Command\CommandInterface;

final class CreateClinicCommand implements CommandInterface
{
    private string $inn;
    private string $name;
    private string $legalForm;
    private string $country;
    private string $post_code;
    private string $region;
    private string $city;
    private string $street;
    private string $building;
    private array $directions;
    private string $lat;
    private string $lon;

    public function __construct(
      string $inn,
      string $legalForm,
      string $name,
      string $country,
      string $post_code,
      string $region,
      string $city,
      string $street,
      string $building,
      string $lat,
      string $lon,
      array $directions
  )
  {
      $this->inn = $inn;
      $this->legalForm = $legalForm;
      $this->name = $name;
      $this->country = $country;
      $this->post_code = $post_code;
      $this->region = $region;
      $this->city = $city;
      $this->street = $street;
      $this->building = $building;
      $this->lat = $lat;
      $this->lon = $lon;
      $this->directions = $directions;
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

    /**
     * @return array
     */
    public function getDirections(): array
    {
        return $this->directions;
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLon(): string
    {
        return $this->lon;
    }
}