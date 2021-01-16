<?php
declare(strict_types=1);

namespace License\Application\Middleware;


use Dadata\DadataClient;

final class Location
{
    /**
     * @var DadataClient
     */
    private DadataClient $dadata;
    private string $country;
    private string $region;
    private string $city;
    private string $street;
    private string $house;
    private string $lat;
    private string $lon;


    public function __construct()
    {
        $token = "e64a7eda4700b84b3c8fc4385b2ba2f0b1a0733f";
        $secret = "ff2e80c3b2ccec1dfa4e3e76cdc422b66da7b880";
        $this->dadata = new DadataClient($token, $secret);
    }

    public function getExtractedData(string $address)
    {
        $response = $this->dadata->clean("address", $address);
       // var_dump($response);
        $this->country = $response["country"];
        $this->region = $response["region"];
        $this->city = $response["city"] ? $response["city"] : $response["region"];
        $this->street = $response["street"];
        $this->house = $response["house"];
        $this->lat = $response["geo_lat"];
        $this->lon = $response["geo_lon"];
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