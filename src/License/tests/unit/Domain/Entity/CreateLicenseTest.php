<?php
declare(strict_types=1);

namespace License\tests\unit\Domain\Entity;


use DateTimeImmutable;
use License\Domain\Entity\License;
use License\Domain\Events\LicenseAddressChanged;
use License\Domain\Events\LicenseCreated;
use License\Domain\VO\Address;
use License\Domain\VO\Id;
use License\Domain\VO\Work;
use PHPUnit\Framework\TestCase;

final class CreateLicenseTest extends TestCase
{
     public function testCreateLicense() : void {
         $license = new License(
             $id = Id::next(),
             $inn = '7729695811',
             $name = 'Клинический госпиталь на Яузе',
             $post_address = 'Москва, Волочаевская ул, 15 к.1.',
             new Address(
                 $country = '',
                 $region = '',
                 $city = '',
                 $street = '',
                 $house = '',
                 $lat = '',
                 $lon = ''
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
         $this->assertEquals($name, $license->getName());
         $this->assertEquals($post_address, $license->getPostAddress());
         $this->assertEquals($works, $license->getWorks());
         $this->assertEquals($license::ADDRESS_UNCHECKED,$license->getStatus());
         $this->assertNotEmpty($events = $license->releaseEvents());
         $this->assertInstanceOf(LicenseCreated::class, end($events));
     }
     /**
     * Смена адреса у лицензии
     */
    public function testChangeAddress(): void
    {
        $license = (new CreateLicenseBuilder())->build();
        $license->changeAddress(new Address($country = 'Россия', $region = 'Москва', $city = 'Москва', $street = 'Волочаевская', $house = '15', $lat = '12.234', $lon = '34.234234'));
        $this->assertEquals($country, $license->getAddress()->getCountry());
        $this->assertEquals($region, $license->getAddress()->getRegion());
        $this->assertEquals($city, $license->getAddress()->getCity());
        $this->assertEquals($street, $license->getAddress()->getStreet());
        $this->assertEquals($house, $license->getAddress()->getHouse());
        $this->assertEquals($lat, $license->getAddress()->getLat());
        $this->assertEquals($lon, $license->getAddress()->getLon());
        $this->assertEquals($license::ADDRESS_CHECKED, $license->getStatus());
        $this->assertNotEmpty($events = $license->releaseEvents());
        $this->assertInstanceOf(LicenseAddressChanged::class, end($events));
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
}