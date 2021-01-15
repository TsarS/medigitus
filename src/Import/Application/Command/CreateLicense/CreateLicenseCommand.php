<?php
declare(strict_types=1);

namespace Import\Application\Command\CreateLicense;


use Import\Application\Command\CommandInterface;

final class CreateLicenseCommand implements CommandInterface
{
    private string $inn;
    private string $post_address;
    private array $works;
    private string $country;
    private string $region;
    private string $city;
    private string $street;
    private string $house;
    private string $name;


    public function __construct(
        string $inn,
        string $name,
        string $post_address,
        string $country,
        string $region,
        string $city,
        string $street,
        string $house,
        array $works
    )
    {

        $this->inn = $inn;
        $this->post_address = $post_address;
        $this->works = $works;
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
        $this->name = $name;
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


}