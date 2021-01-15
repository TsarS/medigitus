<?php
declare(strict_types=1);

namespace Import\tests\unit\Domain\Entity;


use DateTimeImmutable;
use Import\Domain\Entity\License;
use Import\Domain\VO\Address;
use Import\Domain\VO\Id;
use Import\Domain\VO\Work;
use PHPUnit\Framework\TestCase;

final class CreateLicenseTest extends TestCase
{
    public function testCreateLicense()
    {

        $license = new License(
            $id = Id::next(),
            $inn = '2221243213',
            $name = 'Госпиталь какой-то',
            $post_address = 'Кремль, д.1',
            new Address(
                $country = 'Российская Федерация',
                $region = 'Россия',
                $city = 'Москва',
                $street = 'Волочаевская',
                $house = '1'
            ),
            $works = [
                new Work('100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
                new Work('100.1.2. анестезиологии и реаниматологии', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
                new Work('100.1.19. операционному делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
                new Work('100.1.24. сестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия')
            ],
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($inn, $license->getInn());
        $this->assertEquals($post_address, $license->getPostAddress());
        $this->assertEquals($works, $license->getWorks());
    }

    public function testAddWorkToCreatedLicense(): void
    {
        $addedWorks = [
            new Work('100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1.2. анестезиологии и реаниматологии', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1.19. операционному делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1.24. сестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'),
            new Work('100.1. при первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.11.2020', 'Медицинская лицензия')
        ];
        $license = (new CreateLicenseBuilder())->build();
        $license->addWork(new Work('100.1. при первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.11.2020', 'Медицинская лицензия'));
        $this->assertEquals($addedWorks, $license->getWorks());
    }

    public function testChangeAddress(): void
    {
        $license = (new CreateLicenseBuilder())->build();
        $license->changeAddress(new Address($country = 'Россия', $region = 'Москва', $city = 'Москва', $street = 'Волочаевская', $house = '15', $lat = '123', $lon = '123213'));
        $this->assertEquals($country, $license->getAddress()->getCountry());
        $this->assertEquals($region, $license->getAddress()->getRegion());
        $this->assertEquals($city, $license->getAddress()->getCity());
        $this->assertEquals($street, $license->getAddress()->getStreet());
        $this->assertEquals($house, $license->getAddress()->getHouse());
        $this->assertEquals($lat, $license->getAddress()->getLat());
        $this->assertEquals($lon, $license->getAddress()->getLon());


    }
}