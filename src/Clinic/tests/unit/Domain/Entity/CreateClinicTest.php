<?php
declare(strict_types=1);

namespace Clinic\Tests\Unit\Domain\Entity;

use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\Events\ClinicCreated;
use Clinic\Domain\Events\ClinicRenamed;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Name;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateClinicTest extends TestCase
{
    public function testIsClinicCreated()
    {

        $clinic = new Clinic(
            $id = Id::next(),
            $legal = new Legal('7729695811',  'ООО'),
            $name = new Name('Клинический госпиталь на Яузе'),
            $address = new Address(
                $country = 'Российская Федерация',
                $post_code = '111033',
                $city = 'Москва',
                $region = 'Москва',
                $street = 'Волочаевская',
                $house = 'д. 15, к.1',
                $lat = 55.8782557,
                $lon = 37.65372
            ),
            ['Аллергология','Гинекология','Травматология'],
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($id,$clinic->getId());
        $this->assertEquals($legal,$clinic->getLegal());
        $this->assertEquals($name,$clinic->getName());
        $this->assertEquals($address,$clinic->getAddress());
        $this->assertEquals($date,$clinic->getDate());
        $this->assertEquals($name,$clinic->getName());
        $this->assertNotEmpty($events = $clinic->releaseEvents());
        $this->assertInstanceOf(ClinicCreated::class, end($events));

    }

    public function testRenameClinic() {
        $clinic = (new CreateClinicBuilder())->build();
        $clinic->rename(new Name($newName= 'Госпиталь на Яузе'));
        $this->assertEquals($newName,$clinic->getName()->getName());
        $this->assertNotEmpty($events = $clinic->releaseEvents());
        $this->assertInstanceOf(ClinicRenamed::class, end($events));
    }

}
