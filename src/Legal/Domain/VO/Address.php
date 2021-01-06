<?php
declare(strict_types=1);

namespace Legal\Domain\VO;


use Legal\Domain\Exception\Address\AddressMustHaveBuildingException;
use Legal\Domain\Exception\Address\AddressMustHaveCityException;
use Legal\Domain\Exception\Address\AddressMustHavePostCodeException;
use Legal\Domain\Exception\Address\AddressMustHaveRegionException;
use Legal\Domain\Exception\Address\AddressMustHaveStreetException;
use Legal\Domain\Exception\Address\PostCodeMustHave6DigitsException;

final class Address
{
    private string $country = 'Российская Федерация';
    private string $post_code;
    private string $region;
    private string $city;
    private string $street;
    private string $building;

    public function __construct(
        string $country,
        string $post_code,
        string $region,
        string $city,
        string $street,
        string $building
    )
    {
        if (empty($post_code)) {
            throw new AddressMustHavePostCodeException($post_code);
        }
        if (empty($region)) {
            throw new AddressMustHaveRegionException($region);
        }
        if (empty($city)) {
            throw new AddressMustHaveCityException($city);
        }
        if (empty($street)){
            throw new AddressMustHaveStreetException($street);
        }
        if (empty($building)) {
            throw new AddressMustHaveBuildingException($building);
        }
        if (\mb_strlen($post_code, 'utf8') !== 6) {
            throw new PostCodeMustHave6DigitsException($post_code);
        }
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
     * @return string
     */
    public function getFullAddress(): string
    {
        return $this->post_code.', '.$this->region.', '.$this->city.', '.$this->street.', '.$this->building ;
    }
}
