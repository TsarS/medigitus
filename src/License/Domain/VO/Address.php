<?php
declare(strict_types=1);

namespace License\Domain\VO;


final class Address
{
    private string $country;
    private string $region;
    private string $city;
    private string $street;
    private string $house;
    private ?string $lat;
    private ?string $lon;


    public function __construct(
        string $country,
        string $region,
        string $city,
        string $street,
        string $house,
        ?string $lat = '0.0',
        ?string $lon = '0.0'
    )
    {
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
    $str = "(142.6278389135, 43.29162915041)";
    // remove the parentheses
    $clean = substr($str, 1, -1);
    $coord = explode(', ', $clean);
    $long =  floatval($coord[0]); // cast string to float
    $lat = floatval($coord[1]); // case string to float
    echo "Long : ".$long."\r\n";
    echo "Lat : ".$lat."\r\n";
     */

    /**
     * @return string
     */
    public function getLat() : string
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