<?php
declare(strict_types=1);

namespace Clinic\Tests\Unit\Domain\Entity;

use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\VO\Address;
use Clinic\Domain\VO\Id;
use Clinic\Domain\VO\Legal;
use Clinic\Domain\VO\Licence;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateClinicTest extends TestCase
{
    public function test_IsClinicCreated()
    {

        $clinic = new Clinic(
            $id = Id::next(),
            $legal = new Legal('7729695811', 'ООО "Клинический госпиталь на Яузе', 'ООО'),
            $address = new Address(
                $country = 'Российская Федерация',
                $post_code = '111033',
                $city = 'Москва',
                $region = 'Москва',
                $street = 'Волочаевская',
                $house = 'д. 15, к.1',
                $lat = 2.34234234,
                $lon = 53.24234234
            ),
            [new Licence($number = 'ЛО-77-01-016723',$date = '2018-09-25',['fdgdfg'])],
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($id,$clinic->getId());
        $this->assertEquals($legal,$clinic->getLegal());
        $this->assertEquals($address,$clinic->getAddress());
        $this->assertEquals($date,$clinic->getDate());




    }
}
