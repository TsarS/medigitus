<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Address
{
    private string $country = "Российская Федерация";
    private string $post_code;
    private string $region;
    private string $city;
    private string $street;
    private string $house;
    private float $lat;
    private float $lon;

    public function __construct(
        string $country,
        string $post_code,
        string $region,
        string $city,
        string $street,
        string $house,
        float $lat,
        float $lon
    )
    {

        $this->country = $country;
        $this->post_code = $post_code;
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
    public function getHouse(): string
    {
        return $this->house;
    }

    /**
     * @return int
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return int
     */
    public function getLon(): float
    {
        return $this->lon;
    }


}