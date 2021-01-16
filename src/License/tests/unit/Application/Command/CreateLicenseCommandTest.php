<?php
declare(strict_types=1);

namespace License\tests\unit\Application\Command;


use License\Application\Command\CreateLicense\CreateLicenseCommand;
use PHPUnit\Framework\TestCase;

final class CreateLicenseCommandTest extends TestCase
{
   public function testCreateCreateLicenseCommand(): void {

       $createLicense = new CreateLicenseCommand(
           $inn = '7729695811',
           $name = 'Обществе с ограниченной ответственностью "Клинический госпиталь на Яузе"',
           $post_address = 'Москва, Волочаевская ул. д.15 к.1',
           $country = '',
           $region = '',
           $city = '',
           $street = '',
           $house = '',
           $lat = '0' ,
           $lon = '0',
           $works = [
               ['100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'],
               ['100.1.2. анестезиологии и реаниматологии', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'],
               ['100.1.19. операционному делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия'],
               ['100.1.24. сестринскому делу', 'ФС-50-01-002470', '04.12.2020', 'Медицинская лицензия']
           ]);
       $this->assertEquals($inn, $createLicense->getInn());
       $this->assertEquals($name, $createLicense->getName());
       $this->assertEquals($post_address, $createLicense->getPostAddress());
       $this->assertEquals($country, $createLicense->getCountry());
       $this->assertEquals($region, $createLicense->getRegion());
       $this->assertEquals($city, $createLicense->getCity());
       $this->assertEquals($street, $createLicense->getStreet());
       $this->assertEquals($house, $createLicense->getHouse());
   }
}