<?php
declare(strict_types=1);

namespace Import\tests\unit\Domain\Entity;


use DateTimeImmutable;
use Import\Domain\Entity\License;
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
            $post_address = 'Общество с ограниченной ответственностью "КЛИНИКА НОРМА"',
            $works = [
                new Work('100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
                new Work('100.1.2. анестезиологии и реаниматологии','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
                new Work('100.1.19. операционному делу','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
                new Work('100.1.24. сестринскому делу','ФС-50-01-002470','04.12.2020','Медицинская лицензия')
            ],
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($inn,$license->getInn());
        $this->assertEquals($post_address,$license->getPostAddress());
        $this->assertEquals($works,$license->getWorks());

      /*
        $this->assertEquals($number,$license->getNumber());
        $this->assertEquals($license_date,$license->getLicenseDate());
        $this->assertEquals($license_type,$license->getLicenseType());
      */
        /*
        $this->assertEquals($works,$license->getWorks());
        */
    }
    public function testAddWorkToCreatedLicense() : void {
        $addedWorks = [
            new Work('100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
            new Work('100.1.2. анестезиологии и реаниматологии','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
            new Work('100.1.19. операционному делу','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
            new Work('100.1.24. сестринскому делу','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
            new Work('100.1. при первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:','ФС-50-01-002470','04.11.2020','Медицинская лицензия')
        ];
        $license = new License(
            $id = Id::next(),
            $inn = '2221243213',
            $post_address = 'Общество с ограниченной ответственностью "КЛИНИКА НОРМА"',
            $works = [
                new Work('100.1. при оказании первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
                new Work('100.1.2. анестезиологии и реаниматологии','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
                new Work('100.1.19. операционному делу','ФС-50-01-002470','04.12.2020','Медицинская лицензия'),
                new Work('100.1.24. сестринскому делу','ФС-50-01-002470','04.12.2020','Медицинская лицензия')
            ],
            $date = new DateTimeImmutable()
        );
        $license->addWork( new Work('100.1. при первичной доврачебной медико-санитарной помощи в амбулаторных условиях по:','ФС-50-01-002470','04.11.2020','Медицинская лицензия'));
        $this->assertEquals($addedWorks,$license->getWorks());

    }
}