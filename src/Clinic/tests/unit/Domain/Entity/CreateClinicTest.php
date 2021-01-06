<?php
declare(strict_types=1);

namespace Clinic\Tests\Unit\Domain\Entity;

use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\Events\ClinicCreated;
use Clinic\Domain\Events\ClinicRenamed;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateClinicTest extends TestCase
{
    public function testIsClinicCreated()
    {

        $clinic = new Clinic(
            $id = Id::next(),
            $legal = new Legal('7729695811', 'Общество с ограниченной ответственностью "Клинический госпиталь на Яузе"', 'ООО'),
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
        $this->assertEquals($address,$clinic->getAddress());
        $this->assertEquals($date,$clinic->getDate());
        $this->assertNotEmpty($events = $clinic->releaseEvents());
        $this->assertInstanceOf(ClinicCreated::class, end($events));

    }

    public function testRenameClinic() {
        $clinic = (new CreateClinicBuilder())->build();
        $clinic->rename($newName= 'Госпиталь на Яузе');
        $this->assertEquals($newName,$clinic->getName());
        $this->assertNotEmpty($events = $clinic->releaseEvents());
        $this->assertInstanceOf(ClinicRenamed::class, end($events));
    }

}
