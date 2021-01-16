<?php
declare(strict_types=1);

namespace License\tests\unit\Domain\Entity;


use Import\Domain\VO\Address;
use Import\tests\unit\Domain\Entity\CreateLicenseBuilder;

final class ChangeAddressTest
{
   public function testChangeAddress() : void {
       $license = (new CreateLicenseBuilder())->build();
       $license->changeAddress(new Address(

       ));
   }
}