<?php
declare(strict_types=1);

namespace License\Application\Command\CreateLicense;


use License\Application\Command\CommandInterface;

final class CreateLicenseCommand implements CommandInterface
{
    private string $inn;
    private string $post_address;
    private string $country;
    private string $region;
    private string $city;
    private string $street;
    private string $house;
    private string $name;
    private string $lat;
    private string $lon;
    private array $works;


    public function __construct(
        string $inn,
        string $name,
        string $post_address,
        string $country,
        string $region,
        string $city,
        string $street,
        string $house,
        string $lat,
        string $lon,
        array $works
    )
    {
        $this->inn = $inn;
        $this->name = $name;
        $this->post_address = $post_address;
        $this->works = $works;
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;

        $this->lat = $lat;
        $this->lon = $lon;
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
     * @return array
     */
    public function getWorks(): array
    {
        return $this->works;
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
    public function getHouse(): string
    {
        return $this->house;
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
    public function getLon(): string
    {
        return $this->lon;
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }


}