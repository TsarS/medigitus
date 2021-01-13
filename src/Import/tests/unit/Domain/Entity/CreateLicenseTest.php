<?php
declare(strict_types=1);

namespace Import\tests\unit\Domain\Entity;


use Import\Domain\Entity\License;
use PHPUnit\Framework\TestCase;

final class CreateLicenseTest extends TestCase
{
    public function testCreateLicense()
    {

        $license = new License(
            $inn = '2221243213',
            $post_address = 'Общество с ограниченной ответственностью "КЛИНИКА НОРМА"',
            $number = 'ФС-50-01-002470',
            $license_date = '04.12.2020',
            $license_type = 'Медицинская лицензия',
            $works = [
                '100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:',
                '100.1.2. анестезиологии и реаниматологии',
                '100.1.19. операционному делу',
                '100.1.24. сестринскому делу'
            ]
        );
        $this->assertEquals($inn,$license->getInn());
        $this->assertEquals($post_address,$license->getPostAddress());
        $this->assertEquals($number,$license->getNumber());
        $this->assertEquals($license_date,$license->getLicenseDate());
        $this->assertEquals($license_type,$license->getLicenseType());
        $this->assertEquals($works,$license->getWorks());



    }
}