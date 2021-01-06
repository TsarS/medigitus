<?php
declare(strict_types=1);

namespace Legal\tests\unit\Domain\Entity;


use DateTimeImmutable;
use Legal\Domain\Entity\Legal;
use Legal\Domain\Events\LegalCreated;
use Legal\Domain\Exception\Address\AddressMustHaveBuildingException;
use Legal\Domain\Exception\Address\AddressMustHaveCityException;
use Legal\Domain\Exception\Address\AddressMustHavePostCodeException;
use Legal\Domain\Exception\Address\AddressMustHaveRegionException;
use Legal\Domain\Exception\Address\AddressMustHaveStreetException;
use Legal\Domain\Exception\Address\PostCodeMustHave6DigitsException;
use Legal\Domain\Exception\Inn\EmptyInnException;
use Legal\Domain\Exception\Inn\NoValidInnException;
use Legal\Domain\Exception\Inn\NoValidLengthInnException;
use Legal\Domain\Exception\LegalForm\EmptyLegalFormException;
use Legal\Domain\Exception\LegalForm\NoValidLegalFormException;
use Legal\Domain\Exception\Name\LegalMustHaveNameException;
use Legal\Domain\Exception\Ogrn\EmptyOgrnException;
use Legal\Domain\Exception\Ogrn\NoValiOgrnException;
use Legal\Domain\VO\Address;
use Legal\Domain\VO\Id;
use Legal\Domain\VO\Inn;
use Legal\Domain\VO\LegalForm;
use Legal\Domain\VO\Name;
use Legal\Domain\VO\Ogrn;
use PHPUnit\Framework\TestCase;
use Legal\tests\unit\Domain\Entity\CreateLegalBuilder;


final class CreateLegalTest extends TestCase
{
    public function testCreateLegalEntity()
    {
        $legal = new Legal(
            $id = Id::next(),
            $inn = new Inn('7729695811'),
            $ogrn = new Ogrn('1117746919597'),
            $name = new Name('Общество с ограниченной ответственностью "Клинический госпиталь на Яузе"'),
            $legalForm = new LegalForm('Общество с ограниченной ответственностью'),
            $address = new Address('Российская Федерация', '111033', 'г. Москва', 'Москва', 'Волочаевская','15к1'),
            $date = new DateTimeImmutable()
        );
        $this->assertEquals($id, $legal->getId(),'Проверяем, что возвращается ID');
        $this->assertEquals($inn, $legal->getInn());
        $this->assertEquals($ogrn, $legal->getOgrn());
        $this->assertEquals($name, $legal->getName());
        $this->assertEquals($legalForm, $legal->getLegalForm());
        $this->assertEquals($address, $legal->getAddress());
        $this->assertEquals($date, $legal->getDate());
        $this->assertTrue($legal->getId()->isEqualTo($id));

        $this->assertNotEmpty($events = $legal->releaseEvents());
        $this->assertInstanceOf(LegalCreated::class, end($events));
    }
    public function testReturnStringId(): void {
        $id = '7729-32423-695811';
        $legal =  (new CreateLegalBuilder())->withId(new Id($id))->build();
        $this->assertStringContainsString($id, $legal->getId()->getId());

    }

    public function testReturnStringInn(): void {
        $inn = '7729695811';
        $legal =  (new CreateLegalBuilder())->withInn(new Inn($inn))->build();
        $this->assertStringContainsString($inn, $legal->getInn()->getInn());
    }
    public function testReturnStringName(): void {
        $name = 'Общество с ограниченной ответственностью "Клинический госпиталь на Яузе"';
        $legal =  (new CreateLegalBuilder())->withName(new Name($name))->build();
        $this->assertStringContainsString($name, $legal->getName()->getName());
    }
    public function testReturnStringOgrn(): void {
        $ogrn = '1117746919597';
        $legal =  (new CreateLegalBuilder())->withOgrn(new Ogrn($ogrn))->build();
        $this->assertStringContainsString($ogrn, $legal->getOgrn()->getOgrn());
    }


    /**
     * Проверка на отсутствие ИНН
     */
    public function testWithoutInn(): void
    {
        $this->expectException(EmptyInnException::class);
        (new CreateLegalBuilder())->withInn(new Inn(''))->build();
    }

    /**
     * Проверка на правильность контрольной суммы ИНН
     */
    public function testWithWrongControlSummInn(): void
    {
        $this->expectException(NoValidInnException::class);
        (new CreateLegalBuilder())->withInn(new Inn('7729695810'))->build();
    }

    /**
     * Проверка ИНН - длина меньше 10
     */
    public function testWithWrongLength9Inn(): void
    {
        $this->expectException(NoValidLengthInnException::class);
        (new CreateLegalBuilder())->withInn(new Inn('772969581'))->build();
    }

    /**
     * Проверка ИНН длина - больше 10
     */
    public function testWithWrongLength11Inn(): void
    {
        $this->expectException(NoValidLengthInnException::class);
        (new CreateLegalBuilder())->withInn(new Inn('77296958112'))->build();
    }

    /**
     * Проверка наличия Имени
     */
    public function testWithoutName(): void
    {
        $this->expectException(LegalMustHaveNameException::class);
        (new CreateLegalBuilder())->withName(new Name(''))->build();
    }

    /**
     * Проверка наличия ОГРН
     */
    public function testWithoutOgrn(): void
    {
        $this->expectException(EmptyOgrnException::class);
        (new CreateLegalBuilder())->withOgrn(new Ogrn(''))->build();
    }

    /**
     * Проверка валидности ОГРН
     */
    public function testNoValidOgrn(): void
    {
        $this->expectException(NoValiOgrnException::class);
        (new CreateLegalBuilder())->withOgrn(new Ogrn('dsfds'))->build();
    }

    //////// LegalForm ////////
    /**
     * Проверка наличия формы собственности
     */
    public function testEmptyLegalForm(): void {
        $this->expectException(EmptyLegalFormException::class);
        (new CreateLegalBuilder())->withLegalForm(new LegalForm(''))->build();
    }

    /**
     * Проверка валидности формы собственности

    public function testValidLegalForm(): void {
        $this->expectException(NoValidLegalFormException::class);
        (new CreateLegalBuilder())->withLegalForm(new LegalForm('ssadasdadas'))->build();
    }
     */

    /**
     * Проверка возврата частная или государственная
     */
    public function testPrivateOrStateLegalFormPrivate(): void {
        $legalForm = 'Общество с ограниченной ответственностью';
        $legal = (new CreateLegalBuilder())->withLegalForm(new LegalForm($legalForm))->build();
        $this->assertEquals(LegalForm::PRIVATE,$legal->getStateOrPrivate());
    }
    public function testPrivateOrStateLegalFormState(): void {
        $legalForm = 'Федеральное государственное унитарное предприятие';
        $legal = (new CreateLegalBuilder())->withLegalForm(new LegalForm($legalForm))->build();
        $this->assertEquals(LegalForm::STATE,$legal->getStateOrPrivate());
    }
    public function testReturnStringLegalForm(): void {
        $legalForm = 'Общество с ограниченной ответственностью';
        $legal =  (new CreateLegalBuilder())->withLegalForm(new LegalForm($legalForm))->build();
        //$this->assertEquals($name, $legal->getName()->getName());
        $this->assertStringContainsString($legalForm, $legal->getLegalForm()->getLegalForm());
    }

    /////// Address /////


    public function testWithEmptyPostCode(): void
    {
        $this->expectException(AddressMustHavePostCodeException::class);
        (new CreateLegalBuilder())->withAddress(new Address('Российская Федерация', '', 'г. Москва', 'Москва', 'Волочаевская','15к1'),)->build();
    }
    public function testWithWrongPostCode(): void
    {
        $this->expectException(PostCodeMustHave6DigitsException::class);
        (new CreateLegalBuilder())->withAddress(new Address('Российская Федерация', '1141033', 'г. Москва', 'Москва', 'Волочаевская','15к1'),)->build();
    }
    public function testWithEmptyRegion(): void
    {
        $this->expectException(AddressMustHaveRegionException::class);
        (new CreateLegalBuilder())->withAddress(new Address('Российская Федерация', '111033', '', 'Москва', 'Волочаевская','15к1'),)->build();
    }
    public function testWithEmptyCity(): void
    {
        $this->expectException(AddressMustHaveCityException::class);
        (new CreateLegalBuilder())->withAddress(new Address('Российская Федерация', '111033', 'г. Москва', '', 'Волочаевская','15к1'),)->build();
    }
    public function testWithEmptyStreet(): void
    {
        $this->expectException(AddressMustHaveStreetException::class);
        (new CreateLegalBuilder())->withAddress(new Address('Российская Федерация', '111033', 'г. Москва', 'Москва', '','15к1'),)->build();
    }
    public function testWithEmptyBuilding(): void
    {
        $this->expectException(AddressMustHaveBuildingException::class);
        (new CreateLegalBuilder())->withAddress(new Address('Российская Федерация', '111033', 'г. Москва', 'Москва', 'Волочаевская',''),)->build();
    }
    public function testReturnStringPostCode(): void {
        $post_code = '111033';
        $legal =  (new CreateLegalBuilder())->build();
        $this->assertStringContainsString($post_code, $legal->getAddress()->getPostCode());
    }
    public function testReturnStringRegion(): void {
        $region = 'г.Москва';
        $legal =  (new CreateLegalBuilder())->build();
        $this->assertStringContainsString($region, $legal->getAddress()->getRegion());
    }
    public function testReturnStringCity(): void {
        $city = 'Москва';
        $legal =  (new CreateLegalBuilder())->build();
        $this->assertStringContainsString($city, $legal->getAddress()->getCity());
    }
    public function testReturnStringStreet(): void {
        $street = 'Волочаевская';
        $legal =  (new CreateLegalBuilder())->build();
        $this->assertStringContainsString($street, $legal->getAddress()->getStreet());
    }
    public function testReturnStringBuilding(): void {
        $building = '15к1';
        $legal =  (new CreateLegalBuilder())->build();
        $this->assertStringContainsString($building, $legal->getAddress()->getBuilding());
    }
    public function testReturnFullAddress(): void {
        $fullAddress = '111033, г.Москва, Москва, Волочаевская, 15к1';
        $legal =  (new CreateLegalBuilder())->build();
        $this->assertStringContainsString($fullAddress, $legal->getAddress()->getFullAddress());
    }

}